<?php
    require "./twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    $consumer_key = "BU43RxgCZpHXQnSQvX0ZIgJjo";
    $consumer_secret = "2LT66G4aegvljkY28e7uF18rsi2w6fWBPEIlsH7mMyhLFWTYBb";
    $accessToken = "1213860625941614592-iaop8j2wBPVBjIBLEO07lGSzVQIIVP";
    $accessTokenSecret = "5JzYK84ho44eKgfgTQtXBs45h424JMHkpTET30rhceulw";

    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $accessToken, $accessTokenSecret);
    $content = $connection->get("account/verify_credentials");

    echo "<pre>";
    print_r($content);
    echo "</pre>";
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheets/css/Index.css" />
        <link rel="stylesheet" href="stylesheets/css/Navbar.css" />
    </head>

    <body>
        <div class="navbar">
            <p>Pokemon</p>
            <p>Sign In with Twitter</p>
        </div>

        <div class="timeline">

        </div>

        <div id="map">
            
        </div>

        <!-- <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 54.9783, lng: -1.6178},
            zoom: 8
            });
        }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNLjoxj2VIWiZJE_54MRL0pO-ruGVB7B4&callback=initMap" async defer></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> -->
    </body>
</html>