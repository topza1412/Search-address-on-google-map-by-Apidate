<?php 
require_once "condb.php";
$db = new Connect;
$db->ConDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Search-address-on-google-map-by-Apidate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="jquery-2.0.3.min.js"></script>

<script type="text/javascript">

//popup search location on google map
function insert_address_search(location,latitude,longitude,address){
    $("#location").val(location);
    $("#latitude").val(latitude);
    $("#longitude").val(longitude);
    $("#address").val(address);
}

function chk_form () {

    if(form1.location.value==""){

        alert('Please select location!');
        return false;
    }
}

//popup windows
function popup(url,name,windowWidth,windowHeight){    
    myleft=(screen.width)?(screen.width-windowWidth)/2:100; 
    mytop=(screen.height)?(screen.height-windowHeight)/2:100;   
    properties = "width="+windowWidth+",height="+windowHeight;
    properties +=",scrollbars=yes, top="+mytop+",left="+myleft;   
    window.open(url,name,properties);
}

</script>

</head>

<body>

<!-- insert into -->
<?php if($_REQUEST['data']=='save'){

$sql = $db->conn->query("insert location set Loc_Location = '$_REQUEST[location]',Loc_Latitude = '$_REQUEST[latitude]',Loc_Longitude = '$_REQUEST[longitude]',Loc_Address = '$_REQUEST[address]',Loc_Date = now()")or die ($db->conn->error());

if($sql==true){
echo "<script>alert('Save complete...');</script>";
}
else {
   echo "<script>alert('Save not complete!');</script>"; 
}

}

?>


<form name="form1" action="?data=save" method="post" onsubmit="return chk_form();" >

                                    <label>Location</label>
                                    <input name="location" type="text" id="location" placeholder="Location" readonly >

                                    <button type="button" onClick="javascript:popup('search_location.php','',1000,600)">Search</button>

                                    <br><br>

                                    <label>Latitude</label>
                                    <input name="latitude" type="text" id="latitude" readonly>

                                    <label>Longitude</label>
                                    <input name="longitude" type="text" id="longitude" readonly>

                                    <br><br>

                                    <label>Address</label>
                                    <textarea name="address" id="address" rows="3" class="form-control" readonly></textarea>

                                    <br><br>

                                    <button type="submit">Submit</button>

</form>

</body>
</html>
