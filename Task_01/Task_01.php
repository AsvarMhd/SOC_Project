<?php

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://covid-19-statistics.p.rapidapi.com/provinces?iso=CHN",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: covid-19-statistics.p.rapidapi.com",
		"X-RapidAPI-Key: 71d1e8d213mshba3e78f9199a98ep10c589jsn31e32cc2ecb6"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$data1 = json_decode($response,true);
    $arr1 = $data1['data'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Province Information</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: rgba(255, 255, 255, 0.5); 
            color: #333;
            background-image: url('R.png'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            margin-top: 30px;
        }

        table {
            width: 100%;
            background-color: rgba(255, 255, 255, 0.2); 
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #343a40;
            color: #fff;
        }

        tbody tr:hover {
            background-color: #e0e0e0;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Province Information</h2>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Province Name</th>
                    <th>Latitudes</th>
                    <th>Longitudes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($arr1 as $v) { ?>
                    <tr>
                        <td><?php echo $v['province']; ?></td>
                        <td><?php echo $v['lat']; ?></td>
                        <td><?php echo $v['long']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>




