<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <title>WeatherJam: </title>
</head>

<body>
<form>
    <div class="form-group">
        <label for="weather"> Tell us where you are </label>
        <input type="city" class="form-control" id="city" value="" placeholder="Enter a city name.">
    </div>
    <button type="submit" id="sendbtn" class="btn btn-default">Submit</button>

</form>

<div id='affichage'></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="meteo.js"></script>

<div id="cityweather"></div>

<?php

?>
</body>

</html>