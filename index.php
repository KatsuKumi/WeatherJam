<!DOCTYPE html>
<?php
include('weatherimgtable.php');
include('mysql.php');
include('load.php');
$backgroundimage = "img/bg.jpg";
$city = urlencode($_POST["city"]);
if (!empty($city)){
    $backgroundimage = $backgroundimg[$weathermain];
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="css/owfont-regular.min.css" rel="stylesheet" type="text/css">
    <link href="css/owfont-regular.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">


    <link href="css/weather-icons-wind.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
    <link href="css/weather-icons.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/style.css">

    <title>WeatherJam: the sound that fits your mood </title>
</head>

<body style=" background: url(<?php echo $backgroundimage; ?>) no-repeat center center fixed;">

<div class="page-header">

    <div id="title" class="col-md-offset-3 col-md-6 col-xs-offset-2 col-xs-8 transp  arentbackground text-center"><a href="index.php"><h1>WeatherJam<br></h1></a> <span id="motto"> the sound that fits your mood. </span></div>
</div>


<div class="row zoom-box" >



    <form id="search" action="index.php" method="post" class="col-md-offset-4 col-md-4 col-xs-offset-2 col-xs-8 transparentbackground">

        <div class="text-center">
            <label for="weather"> Tell us where you are </label>

            <div class="form-inline">



                <input type="text" name="city" class="form-control" id="city" value="" placeholder="Enter a city name.">
                <button type="submit" id="sendbtn" class="btn btn-default"><img src="img/playbutton.png"> </button>

            </div>
        </div>
    </form>

</div>

<?php
if (empty($city)){
    LoadHistory();
}
else {
    ShowWeather();
}
?>
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