<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="style.css"><link href="css/owfont-regular.min.css" rel="stylesheet" type="text/css">
        <link href="css/owfont-regular.min.css" rel="stylesheet" type="text/css">
        <title>WeatherJam: the sound that fits your mood </title>
    </head>

    <body class="container">
    <div class="row"><img src="logo.png" alt="WeatherJamLogo" class="col-md-offset-4 col-md-4 col-xs-offset-2 col-xs-8"></div>
    <div class="page-header">

        <h1 class="text-center"> WeatherJam: the sound that fits your mood. </h1>
    </div>


    <div class="row">

        <form action="index.php" method="post" class="col-md-4 col-lg-4 col-sm-8 col-xs-8">

            <div class="form-group">

                <label for="weather"> Tell us where you are </label>
                <input type="text" name="city" class="form-control" id="city" value="" placeholder="Enter a city name.">

            </div>
            <button type="submit" id="sendbtn" class="btn btn-default">Submit</button>
        </form>
    </div>


    <div id='affichage'>

        <?php
        $city = htmlspecialchars($_POST["city"]);
        if (!empty($city)){
            $weatherjson = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$city."&units=metric&appid=0e6f23f3b33300d4b282e44cd350003e");
            $weatherarray = json_decode($weatherjson, true);
            $pressure = $weatherarray["main"]["pressure"]* 0.00001 *100;
            $temp = $weatherarray["main"]["temp"];
            $humidity = $weatherarray["main"]["humidity"];
        }
        ?>

        <i class="owf owf-<?php echo $weatherarray['weather'][0]['id'];?> owf-5x"></i>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    </body>

</html>