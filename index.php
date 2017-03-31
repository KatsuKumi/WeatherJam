<!DOCTYPE html>
<?php include('weatherimgtable.php');
include('mysql.php');
$backgroundimage = "bg.jpg";
$city = htmlspecialchars($_POST["city"]);
    if (!empty($city)) {
        $weatherjson = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=" . $city . "&units=metric&appid=0e6f23f3b33300d4b282e44cd350003e");
        $weatherarray = json_decode($weatherjson, true);
        $pressure = $weatherarray["main"]["pressure"] * 0.00001 * 100;
        $temp = $weatherarray["main"]["temp"];
        $humidity = $weatherarray["main"]["humidity"];
        $winddegree = $weatherarray["wind"]["deg"];
        $windspeed = $weatherarray["wind"]["speed"];
        $iconweather = $weatherarray['weather'][0]['id'];
        $weather = $weatherarray['weather'][0]['description'];
        $weathermain = $weatherarray['weather'][0]['main'];
        $weatherjsontom = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?q=" . $city . "&appid=0e6f23f3b33300d4b282e44cd350003e");
        $weatherarraytom = json_decode($weatherjsontom, true)["list"][8];
        $weathertom = $weatherarraytom['weather'][0]['description'];
        $weathermaintom = $weatherarraytom['weather'][0]['main'];
        $backgroundimage = $backgroundimg[$weathermain];

        $keyword = $keywordweather[$weathermain][array_rand($keywordweather[$weathermain])];
        $listid = file_get_contents("http://api.deezer.com/search?q=".$keyword);
        $listidarray = json_decode($listid, true);
        $randomtabletrackdeez = $listidarray["data"][array_rand($listidarray["data"])];
        $trackid = $randomtabletrackdeez['id'];
        $titledeeze = $randomtabletrackdeez['title'];

        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "INSERT INTO search_history (ville,temp,meteo,titre) VALUES( '$city', '$temp', '$weather', '$titledeeze')";
        $conn->query($sql);
        $conn->close();
    }

?>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="css/owfont-regular.min.css" rel="stylesheet" type="text/css">
    <link href="css/owfont-regular.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">
    <link rel="stylesheet" href="style.css">


    <link href="css/weather-icons-wind.min.css" rel="stylesheet" type="text/css">
    <link href="css/weather-icons.css" rel="stylesheet" type="text/css">
    <title>WeatherJam: the sound that fits your mood </title>
</head>

<body class="container" style=" background: url('<?php echo $backgroundimage; ?>') no-repeat center center fixed;">

<div class="page-header">

    <div class="col-md-offset-3 col-md-6 col-xs-offset-2 col-xs-8 transparentbackground"><h1 class="text-center"> WeatherJam: the sound that fits your moods. </h1></div>
</div>


<div class="row zoom-box" >



    <form id="search" action="index.php" method="post" class="col-md-offset-4 col-md-4 col-xs-offset-2 col-xs-8 transparentbackground">

        <div class="text-center">
            <label for="weather"> Tell us where you are </label>

            <div class="form-inline">



                <input type="text" name="city" class="form-control" id="city" value="" placeholder="Enter a city name.">
                <button type="submit" id="sendbtn" class="btn btn-default">Submit</button>

            </div>
        </div>
    </form>

</div>
<div id="history" class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8 transparentbackground container" type='hidden'>

    <div class="row">
        <div class="col-lg-12 col-md-12 titleweather" >
            History
        </div>
    </div>
    <?php
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM search_history LIMIT 10;";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo  $row["date"]. " - Ville : " .  $row["ville"]. " - Temp : " . $row["temp"]. " - Music Title : " .$row["titre"]."<br>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>
</div>


    <?php
    if (!empty($city)){
        echo "
<div id='affichage' class=\"col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8 transparentbackground container zoom-box\">

    <div class=\"row\">
        <div class=\"col-lg-12 col-md-12 titleweather\" >
            Today 
        </div>
    </div>
    <div class=\"row weathercontent\">
        <div class=\"col-md-3 col-xs-12\"><br>
            <div id=\"centeredleft\">
                <div class=\"weatherico\">
                    <i class=\"wi ".$weatherimg[$weathermain]." owf-5x\"></i><br>
                    <i class=\"wi wi-wind-beaufort-".round($windspeed, 0)." owf-5x\"></i>
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
            <i class=\"wi wi-wind towards-".round($winddegree, 0)."-deg owf-5x\"></i>
            <span class=\"degreetitle\">".round($winddegree, 0)."</span><i class=\"wi wi-degrees owf-4x\"></i><br>
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
                    <i class=\"wi ".$weatherimg[$weathermaintom]." owf-5x\"></i>

                </div>

                <div class=\"titleleft\">
                    <span>".ucfirst($weathertom)."</span>
                </div><br>
            </div>

        </div>
    </div>
    </div>";
        echo '<div id="playlist" class="col-md-offset-4 col-md-4 col-xs-offset-2 col-xs-8 transparentbackground ">';
        echo '<h1 class="text-center">Deezer</h1>';
        echo '<h2 class="text-center">'.$titledeeze.'</h2>';
        echo '<div class="centered"><div class="deezer-widget-player" data-src="http://www.deezer.com/plugins/player?format=classic&autoplay=false&playlist=true&width=350&height=350&color=007FEB&layout=light&size=medium&type=tracks&id='.$trackid.'&app_id=230222" data-scrolling="no" data-frameborder="0" data-allowTransparency="true" data-width="350" data-height="90"></div></div>';
        echo '</div>';
        echo '</div>';
    }
    ?>




<div id="weatherforecast" class="col-md-offset-4 col-md-4 col-xs-offset-2 col-xs-8 panel panel-default ">
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    (function(d, s, id) {
        var js, djs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "http://e-cdn-files.deezer.com/js/widget/loader.js";
        djs.parentNode.insertBefore(js, djs);
    }(document, "script", "deezer-widget-loader"));

</script>

</body>

</html>