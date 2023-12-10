<?php

$ccode=$_GET['q'];



$url = "https://restcountries.com/v3.1/alpha/$ccode";
$data = file_get_contents($url);
$data = json_decode($data,true);
$flag = $data[0]['flags']['png'];
$cname = $data[0]['name']['common'];
$region = $data[0]['region'];
$sregion = $data[0]['subregion'];
$popu = number_format($data[0]['population']);
$area = number_format($data[0]['area']);
//$borders = join(",",$data[0]['borders']);


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
    }

    th, td {
      padding: 12px;
      text-align: left;
      border: 1px solid #dddddd;
    }

    th {
      background-color: #f2f2f2;
    }

    img {
      max-width: 100%;
      height: auto;
    }

    iframe {
      width: 100%;
      height: 200px;
      border: 1px solid #dddddd;
    }
  </style>
</head>
<body>
<table border="1" width="35%">
  <tr><td>Flag</td><td><img src="<?php echo $flag; ?>"/></td></tr>
  
  <tr><td>Country Name</td><td><?php echo $cname; ?></td></tr>
  
  <tr><td>Region</td><td><?php echo $region; ?></td></tr>
  
  <tr><td>SubRegion</td><td><?php echo $sregion; ?></td></tr>
  
  <tr><td>Population</td><td><?php echo $popu; ?></td></td></tr>
  
  <tr><td>Area</td><td><?php echo $area; ?></td></tr>
  
  <tr><td>Border</td><td><?php 
    if(empty($data[0]['borders'])){
      echo NULL;
    }
    else{
      $borders = join (",",$data [0]['borders']);
      echo $borders;
    }
  ?></td></tr>
  
  <tr><td>Map Link</td><td>
    <?php $g=$data [0]['maps']['googleMaps'];
      // echo $g;
    ?>
    <a href="<?php echo $g; ?>" target = "_blank"> Map</a>
  </td></tr>

  <tr><td colspan=2>
    <iframe
      width="100%"
      height="200"
      frameborder="1" style="border:1"
      referrerpolicy="no-referrer-when-downgrade"
      src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDgnKGlPxeEDktqMDvVzRYTwb4nnOKu_Jc&q=<?php echo $cname; ?>&zoom=3"
      allowfullscreen>
    </iframe>

  </td></tr>

</table>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>




