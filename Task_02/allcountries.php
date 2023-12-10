<?php

$url = "https://restcountries.com/v3.1/all";
$data = file_get_contents($url);
$data = json_decode($data,true);
$cname = array();


foreach ($data as $c){
 $ccode = $c['cca2'];
  $cname[$ccode] = $c['name']['common'];
}

?>
<html>
  <head><title></title>
  <script>
    function showCountries(str) {
      if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
        };
          xmlhttp.open("GET","getcountry.php?q="+str,true);
          xmlhttp.send();
      }
    }
  </script>

  <style>
    body {
  font-family: 'Arial', sans-serif;
  background-color: #f8f9fa;
}

.container {
  max-width: 800px;
  margin: 50px auto;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  background-color: #fff;
}

h2 {
  color: #007bff;
  text-align: center;
}

form-group {
  margin-bottom: 20px;
}

form-group label {
  display: block;
  margin-bottom: 5px;
  color: #495057;
}

select {
  width: 100%;
  padding: 10px;
  margin-top: 3px;
  margin-bottom: 10px;
  font-size: 16px;
  color: #495057;
  border: 1px solid #ced4da;
  border-radius: 4px;
  background-color: #fff;
}

select:hover {
  border-color: #007bff;
}

select:focus {
  border-color: #007bff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
  </style>

  
  </head>
  <body>
    <div>Country:
      <select name="code" onchange="showCountries(this.value)">
        <option value="">Select a Country</option>
        <?php foreach ($cname as $k=> $v){ ?>
          <option value = "<?php echo $k; ?>">
          <?php echo $v; ?>
        </option>
        <?php } ?>
      </select>
    </div>
          <div id="txtHint"></div>
  </body>
</html>

