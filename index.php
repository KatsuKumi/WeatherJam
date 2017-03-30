<!DOCTYPE html>
<?php include('weatherimgtable.php')?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link href="css/owfont-regular.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="css/weather-icons-wind.min.css" rel="stylesheet" type="text/css">
    <link href="css/weather-icons.css" rel="stylesheet" type="text/css">
    <title>WeatherJam: the sound that fits your mood </title>
</head>

<body class="container">
<div class="row"><img src="logo.png" alt="WeatherJamLogo" class="col-md-offset-4 col-md-4 col-xs-offset-2 col-xs-8"></div>
<div class="page-header">

    <h1 class="text-center"> WeatherJam: the sound that fits your mood 123434 . </h1>
</div>


<div class="row">



    <form action="index.php" method="post" class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8 panel panel-default">

        <div class="text-center">
            <label for="weather"> Tell us where you are </label>

            <div class="form-inline">



                <input type="text" name="city" class="form-control" id="city" value="" placeholder="Enter a city name.">
                <button type="submit" id="sendbtn" class="btn btn-default">Submit</button>

            </div>
        </div>
    </form>

</div>


<div id='affichage' class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8 panel panel-default container">

    <?php
    $city = htmlspecialchars($_POST["city"]);
    if (!empty($city)){
        $weatherjson = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$city."&units=metric&appid=0e6f23f3b33300d4b282e44cd350003e");
        $weatherarray = json_decode($weatherjson, true);
        /*var_dump($weatherarray);*/
        $pressure = $weatherarray["main"]["pressure"]* 0.00001 *100;
        $temp = $weatherarray["main"]["temp"];
        $humidity = $weatherarray["main"]["humidity"];
        $winddegree = $weatherarray["wind"]["deg"];
        $windspeed = $weatherarray["wind"]["speed"];
        $iconweather = $weatherarray['weather'][0]['id'];
        $weather = $weatherarray['weather'][0]['description'];
        $weatherjsontom = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?q=".$city."&appid=0e6f23f3b33300d4b282e44cd350003e");
        $weatherarraytom = json_decode($weatherjsontom, true)["list"][8];
        $weathertom = $weatherarraytom['weather'][0]['description'];
        echo "
    <div class=\"row weathercontent\">
        <div class=\"col-md-3 col-xs-12\"><br>
            <div id=\"centeredleft\">
                <div class=\"weatherico\">
                    <i class=\"wi ".$weatherimg[$weather]." owf-5x\"></i>

                </div>

                <div class=\"titleleft\">
                    <span>".$city."</span><br>
                    <span>".ucfirst($weather)."</span>
                </div><br>
            </div>
        </div>
        <div id=\"right\" class=\"col-md-5 col-xs-12\">
            <div id=\"stats\">
                <i class=\"wi wi-thermometer owf-3x\"></i><span>".$temp."</span><i class=\"wi wi-celsius owf-3x\"></i><br>
                <i class=\"wi wi-humidity owf-3x\"></i><span>".$humidity." %</span><br>
                <i class=\"wi wi-barometer owf-3x\"></i><span>".$pressure." Bar</span><br>
            </div>

        </div>
        <div class=\"col-lg-3 col-md-12\">

            <i class=\"wi wi-wind towards-".$winddegree."-deg owf-5x\"></i>
            <span class=\"degreetitle\">".$winddegree."</span><i class=\"wi wi-degrees owf-4x\"></i><br>
            <i class=\"wi wi-wind-beaufort-".round($windspeed, 0)." owf-5x\"></i>
        </div>
    </div>
    <hr>
    <div class=\"row\">
        <div class=\"col-lg-12 col-md-12 titleweather\" >
            Tomorrow
        </div>
    </div>
    <div class=\"row weathertommorow\">
        <div class=\"col-lg-12 col-md-12\" >
            <div id=\"centeredleft\">
                <div class=\"weatherico\">
                    <i class=\"wi ".$weatherimg[$weathertom]." owf-5x\"></i>

                </div>

                <div class=\"titleleft\">
                    <span>".ucfirst($weathertom)."</span>
                </div><br>
            </div>

        </div>
    </div>";
    }
    ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</body>

</html>