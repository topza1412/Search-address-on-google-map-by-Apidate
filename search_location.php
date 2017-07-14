<?php
require_once "condb.php";
$db = new Connect;
$db->ConDB();
?>

<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<script src="jquery-2.0.3.min.js"></script>

		<title>Search-address-on-google-map-by-Apidate</title>

<script type="text/javascript">
var geocoder; // กำหนดตัวแปรสำหรับ เก็บ Geocoder Object ใช้แปลงชื่อสถานที่เป็นพิกัด
var map; // กำหนดตัวแปร map ไว้ด้านนอกฟังก์ชัน เพื่อให้สามารถเรียกใช้งาน จากส่วนอื่นได้
var my_Marker; // กำหนดตัวแปรสำหรับเก็บตัว marker
var GGM; // กำหนดตัวแปร GGM ไว้เก็บ google.maps Object จะได้เรียกใช้งานได้ง่ายขึ้น
var icon_mark; // กำหนด icon mark
var infowindow=[]; // กำหนดตัวแปรสำหรับเก็บตัว popup แสดงรายละเอียดสถานที่
var infowindowTmp; // กำหนดตัวแปรสำหรับเก็บลำดับของ infowindow ที่เปิดล่าสุด
function initialize() { // ฟังก์ชันแสดงแผนที่
    GGM=new Object(google.maps); // เก็บตัวแปร google.maps Object ไว้ในตัวแปร GGM
    geocoder = new GGM.Geocoder(); // เก็บตัวแปร google.maps.Geocoder Object
    // กำหนดจุดเริ่มต้นของแผนที่
    var my_Latlng  = new GGM.LatLng(13.7563309,100.50176510000006);
    var my_mapTypeId=GGM.MapTypeId.ROADMAP; // กำหนดรูปแบบแผนที่ที่แสดง
    // กำหนด DOM object ที่จะเอาแผนที่ไปแสดง ที่นี้คือ div id=map_canvas
    var my_DivObj=$("#map_canvas")[0];
    // กำหนด Option ของแผนที่
    var myOptions = {
        zoom: 11, // กำหนดขนาดการ zoom
        center: my_Latlng , // กำหนดจุดกึ่งกลาง จากตัวแปร my_Latlng
        mapTypeId:my_mapTypeId // กำหนดรูปแบบแผนที่ จากตัวแปร my_mapTypeId
    };

    map = new GGM.Map(my_DivObj,myOptions); // สร้างแผนที่และเก็บตัวแปรไว้ในชื่อ map

    //สร้าง icon marker
    icon_mark = new GGM.MarkerImage("map-marker.png",
            new GGM.Size(50, 50),
            new GGM.Point(0, 0),
            new GGM.Point(10.0, 17.0)
            );

   
 <?php
    // loop location in db show on map marker  
    $sql = $db->conn->query("select * from location order by Loc_ID desc");
    while ($show = $sql->fetch_assoc()){
    ?>

    //create location
    var location_mark = new GGM.LatLng('<?php echo $show['Loc_Latitude'];?>','<?php echo $show['Loc_Longitude'];?>');

    my_Marker = new GGM.Marker({
        position: location_mark,
        map: map,
        icon: icon_mark,   
    });

<?php } ?>


my_Marker = new GGM.Marker({ // สร้างตัว marker ไว้ในตัวแปร my_Marker
        position: my_Latlng,  // กำหนดไว้ที่เดียวกับจุดกึ่งกลาง
        map: map, // กำหนดว่า marker นี้ใช้กับแผนที่ชื่อ instance ว่า map
        draggable:true, // กำหนดให้สามารถลากตัว marker นี้ได้
        title:"คลิกลากเพื่อหาตำแหน่งจุดที่ต้องการ!" // แสดง title เมื่อเอาเมาส์มาอยู่เหนือ
    });
     
    // กำหนด event ให้กับตัว marker เมื่อสิ้นสุดการลากตัว marker ให้ทำงานอะไร   
    GGM.event.addListener(my_Marker, 'dragend', function() {
        var my_Point = my_Marker.getPosition();  // หาตำแหน่งของตัว marker เมื่อกดลากแล้วปล่อย
        map.panTo(my_Point); // ให้แผนที่แสดงไปที่ตัว marker 

        // เรียกขอข้อมูลสถานที่จาก Google Map
        geocoder.geocode({'latLng': my_Point}, function(results, status) {
          if (status == GGM.GeocoderStatus.OK) {
            if (results[1]) {
                // แสดงข้อมูลสถานที่ใน textbox
              $("#namePlace").val(results[1].formatted_address); //
              // แสดงข้อมูลสถานที่ใน textbox
              $("#namePlace2").val(results[1].formatted_address); //  
            }
          } else {
              // กรณีไม่มีข้อมูล
            alert("Geocoder failed due to: " + status);
          }
        });   


        $("#lat_value").val(my_Point.lat());  // เอาค่า latitude ตัว marker แสดงใน textbox id=lat_value
        $("#lon_value").val(my_Point.lng());  // เอาค่า longitude ตัว marker แสดงใน textbox id=lon_value 
        $("#zoom_value").val(map.getZoom());  // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_valu          
    });     
 
    // กำหนด event ให้กับตัวแผนที่ เมื่อมีการเปลี่ยนแปลงการ zoom
    GGM.event.addListener(map, 'zoom_changed', function() {
        $("#zoom_value").val(map.getZoom());   // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_value    
    });
 
}
$(function(){
    // ส่วนของฟังก์ชันค้นหาชื่อสถานที่ในแผนที่
    var searchPlace=function(){ // ฟังก์ชัน สำหรับคันหาสถานที่ ชื่อ searchPlace
        var AddressSearch=$("#namePlace").val();// เอาค่าจาก textbox ที่กรอกมาไว้ในตัวแปร
        if(geocoder){ // ตรวจสอบว่าถ้ามี Geocoder Object 
            geocoder.geocode({
                 address: AddressSearch // ให้ส่งชื่อสถานที่ไปค้นหา
            },function(results, status){ // ส่งกลับการค้นหาเป็นผลลัพธ์ และสถานะ
                if(status == GGM.GeocoderStatus.OK) { // ตรวจสอบสถานะ ถ้าหากเจอ
                    var my_Point=results[0].geometry.location; // เอาผลลัพธ์ของพิกัด มาเก็บไว้ที่ตัวแปร
                    map.setCenter(my_Point); // กำหนดจุดกลางของแผนที่ไปที่ พิกัดผลลัพธ์
                    my_Marker.setMap(map); // กำหนดตัว marker ให้ใช้กับแผนที่ชื่อ map                   
                    my_Marker.setPosition(my_Point); // กำหนดตำแหน่งของตัว marker เท่ากับ พิกัดผลลัพธ์
                    $("#lat_value").val(my_Point.lat());  // เอาค่า latitude พิกัดผลลัพธ์ แสดงใน textbox id=lat_value
                    $("#lon_value").val(my_Point.lng());  // เอาค่า longitude พิกัดผลลัพธ์ แสดงใน textbox id=lon_value 
                    $("#zoom_value").val(map.getZoom()); // เอาขนาด zoom ของแผนที่แสดงใน textbox id=zoom_valu

                    // เรียกขอข้อมูลสถานที่จาก Google Map
        geocoder.geocode({'latLng': my_Point}, function(results, status) {
          if (status == GGM.GeocoderStatus.OK) {
            if (results[1]) {
                // แสดงข้อมูลสถานที่ใน textarea
              $("#namePlace2").val(results[1].formatted_address); // 
            }
          } else {
              // กรณีไม่มีข้อมูล
            alert("Geocoder failed due to: " + status);
          }
        });

                }else{
                    // ค้นหาไม่พบแสดงข้อความแจ้ง
                    alert("Geocode was not successful for the following reason: " + status);
                    $("#namePlace").val("");// กำหนดค่า textbox id=namePlace ให้ว่างสำหรับค้นหาใหม่
                 }
            });
        }       
    }
    $("#SearchPlace").click(function(){ // เมื่อคลิกที่ปุ่ม id=SearchPlace ให้ทำงานฟังก์ฃันค้นหาสถานที่
        searchPlace();  // ฟังก์ฃันค้นหาสถานที่
    });
    $("#namePlace").keyup(function(event){ // เมื่อพิมพ์คำค้นหาในกล่องค้นหา
        if(event.keyCode==13){  //  ตรวจสอบปุ่มถ้ากด ถ้าเป็นปุ่ม Enter ให้เรียกฟังก์ชันค้นหาสถานที่
            searchPlace();      // ฟังก์ฃันค้นหาสถานที่
        }       
    });
 
});
$(function(){
    // โหลด สคริป google map api เมื่อเว็บโหลดเรียบร้อยแล้ว
    // ค่าตัวแปร ที่ส่งไปในไฟล์ google map api
    // v=3.2&sensor=false&language=th&callback=initialize
    //  v เวอร์ชัน่ 3.2
    //  sensor กำหนดให้สามารถแสดงตำแหน่งทำเปิดแผนที่อยู่ได้ เหมาะสำหรับมือถือ ปกติใช้ false
    //  language ภาษา th ,en เป็นต้น
    //  callback ให้เรียกใช้ฟังก์ชันแสดง แผนที่ initialize  
    $("<script/>", {
      "type": "text/javascript",
      src: "http://maps.google.com/maps/api/js?v=3.2&sensor=false&language=th&callback=initialize"
    }).appendTo("body");    
});
</script>  


    <script>
function select_location(){
  var location = form_search.namePlace.value;
  var latitude = form_get_detailMap.lat_value.value;
  var longitude = form_get_detailMap.lon_value.value;
  var address = form_search.address.value;

  if(location==""){

    alert('Please select location!');
    return false;
  }
  else if(latitude==0){

    alert('Please search location!');
    return false;
  }

  else {
    //ส่งค่าไปที่ function insert_address_search 
  window.opener.insert_address_search(location,latitude,longitude,address);
  window.close();

}

}

</script>

<style type="text/css">
/* map size */
#map_canvas { 
    width:100%;
    height:400px;
    margin:auto;
    margin-top:10px;
}
</style>

	</head>

<body>

  <h4>Search Location</h4>

<form name="form_search" method="post" action="">

<b>Location</b>
  <input name="namePlace" size="70" type="text" id="namePlace" size="30" />
  <input type="hidden" name="address" id="namePlace2">
  <input type="button" name="SearchPlace" id="SearchPlace" value="Search" />

  </form>

  <hr />

  <form id="form_get_detailMap" name="form_get_detailMap" method="post" action="">

  Latitude <input name="lat_value" type="text" id="lat_value" value="0" size="20" readonly /> 

  Longitude <input name="lon_value" type="text" id="lon_value" value="0" size="20" readonly />

  <input type="button" name="button" id="button" onclick="select_location();" value="Save" />
  
  </form>  

  <!-- show map -->
   <div id="map_canvas"></div>

</body>
</html>