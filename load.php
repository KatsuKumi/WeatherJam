<?php

include('mysql.php');
include('weatherimgtable.php');

$city = urlencode($_POST["city"]);
if (!empty($city)) {
    $weatherjson = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=" . $city . "&units=metric&appid=0e6f23f3b33300d4b282e44cd350003e");
    $weatherarray = json_decode($weatherjson, true);
    $weathermain = $weatherarray['weather'][0]['main'];
}
function LoadHistory(){
    global $servername, $username,$password,$dbname;

        echo '<div id="history" class="col-md-offset-2 col-md-8 col-xs-offset-2 col-xs-8 transparentbackground container" type=\'hidden\'>

    <div class="row">
        <div class="col-lg-12 col-md-12 titleweather" >
            <strong> History </strong>
        </div>
    </div>
    <table class="table table-striped table-responsive">
    <thead>
        <tr>
            <th>Date</th>
            <th>City</th>
            <th>Temperature</th>
            <th>Weather </th>
            <th>Song played</th>

        </tr>
    </thead>
    <tbody>';
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM search_history  ORDER BY date DESC LIMIT 30;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row

            while($row = $result->fetch_assoc()) {
                echo  '
        <tr>
            <td>'.$row["date"].'</td>
            <td>'.$row["ville"].'</td>
            <td>'.$row["temp"].'</td>
            <td>'.$row["meteo"].'</td>
            <td>'. $row["titre"].'</td>

        </tr>

    ';
            }
        } else {
            echo "0 results";
        }
        $conn->close();
        echo "</tbody></table></div>";

}
function ShowWeather(){

    global $servername, $username,$password,$dbname, $city,$keywordweather, $weatherimg, $weatherarray;
    $pressure = $weatherarray["main"]["pressure"] * 0.00001 * 100;
    $temp = $weatherarray["main"]["temp"];
    $humidity = $weatherarray["main"]["humidity"];
    $realcity = $weatherarray["name"];
    $winddegree = $weatherarray["wind"]["deg"];
    $windspeed = $weatherarray["wind"]["speed"];
    $iconweather = $weatherarray['weather'][0]['id'];
    $weather = $weatherarray['weather'][0]['description'];
    $weathermain = $weatherarray['weather'][0]['main'];
    $weatherjsontom = file_get_contents("http://api.openweathermap.org/data/2.5/forecast?q=" . $city . "&appid=0e6f23f3b33300d4b282e44cd350003e");
    $weatherarraytom = json_decode($weatherjsontom, true)["list"][8];
    $weathertom = $weatherarraytom['weather'][0]['description'];
    $weathermaintom = $weatherarraytom['weather'][0]['main'];
    $keyword = $keywordweather[$weathermain][array_rand($keywordweather[$weathermain])];
    $listid = file_get_contents("http://api.deezer.com/search?q=".$keyword);
    $listidarray = json_decode($listid, true);
    $randomtabletrackdeez = $listidarray["data"][array_rand($listidarray["data"])];
    $trackid = $randomtabletrackdeez['id'];
    $titledeeze = $randomtabletrackdeez['title'];

    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "INSERT INTO search_history (ville,temp,meteo,titre) VALUES( '$realcity', '$temp', '$weather', '$titledeeze')";
    $conn->query($sql);
    $conn->close();

    echo "
        <div id='affichage' class=\"col-md-offset-2 col-md-8 col-xs-12 transparentbackground container zoom-box\">

    <div class=\"row\">
        <div class=\"col-xs-12  titleweather\">

            Weather forecast for today in ".$realcity."
        </div>
    </div>

    <div class=\"row\">

        <div class=\"col-lg-4 col-xs-12\"> <i class=\"wi ".$weatherimg[$weathermain]." owf-5x\"></i> </div>
        <div class=\"col-lg-4 col-xs-12\"> <i class=\"wi wi-thermometer owf-4x\"></i><span>".$temp."</span><i class=\"wi wi-celsius owf-3x\"></i><br> </div>
        <div class=\"col-lg-4 col-xs-12\"><i class=\"wi wi-wind-beaufort-".round($windspeed, 0)." owf-4x\"></i> <span>Wind's Strength</span></div>

    </div>

    <div class=\"row\">

        <div class=\"col-lg-4 \"> <span>".ucfirst($weather)."</span> </div>
        <div class=\"col-lg-4 \"> <i class=\"wi wi-humidity owf-4x\"></i><span>".$humidity." %</span> </div>
        <div class=\"col-lg-4 \"> <i class=\"wi wi-wind towards-".round($winddegree, 0)."-deg owf-4x\"></i>
        <span class=\"degreetitle\">".round($winddegree, 0)."</span><i class=\"wi wi-degrees owf-4x\"></i><br>  </div>
    </div>
    <div class=\"col-lg-12 col-md-12 \" ></div>
</div>
    
<div id=\"tomorrow\" class=\"col-md-offset-2 col-md-4 col-xs-12 transparentbackground \">
    <div class=\"row weathertomorow\">
            <div class=\"col-lg-12 col-md-12 \" >
                    <span>Tomorrow</span><br>
                    <i class=\"wi ".$weatherimg[$weathermaintom]." owf-5x\"></i>
                    <span>".ucfirst($weathertom)."</span><br>
            </div>
        </div>
</div>";
    echo '<div id="playlist" class="col-md-4 col-xs-12 transparentbackground ">';
    echo '<h1 class="text-center">Deezer</h1>';
    echo '<h2 class="text-center">'.$titledeeze.'</h2>';
    echo '<div class="centered"><div class="deezer-widget-player" data-src="http://www.deezer.com/plugins/player?format=classic&autoplay=true&playlist=true&width=350&height=350&color=007FEB&layout=light&size=medium&type=tracks&id='.$trackid.'&app_id=230222" data-scrolling="no" data-frameborder="0" data-allowTransparency="true" data-width="350" data-height="90"></div></div>';
    echo '</div>';
    echo '</div>';
}