<?php
    require "./twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    $consumer_key = "BU43RxgCZpHXQnSQvX0ZIgJjo";
    $consumer_secret = "2LT66G4aegvljkY28e7uF18rsi2w6fWBPEIlsH7mMyhLFWTYBb";
    $accessToken = "1213860625941614592-iaop8j2wBPVBjIBLEO07lGSzVQIIVP";
    $accessTokenSecret = "5JzYK84ho44eKgfgTQtXBs45h424JMHkpTET30rhceulw";

    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $accessToken, $accessTokenSecret);
    $tweets = $connection->get("search/tweets", array(
        "q" => "#Pokemon", 
        "lang" => "en", 
        "result_type" => "recent", 
        "geocode" => "53.8175,3.0357,500mi",
        "count" => "50",
        "tweet_mode" => "extended"));
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="stylesheets/css/Index.css" />
        <link rel="stylesheet" href="stylesheets/css/Navbar.css" />
    </head>

    <body>
        <!-- <div class="navbar">
            <p>Pokemon</p>
            <p>Sign In with Twitter</p>
        </div> -->

        <div class="timeline">

        </div>

		<?php
		echo "<pre>";
		print_r($tweets);
		echo "</pre>";
            for($i = 0; $i < count($tweets->statuses); $i++) {
				if(isset($tweets->statuses[$i]->retweeted_status)) continue;
				
				$text = $tweets->statuses[$i]->full_text;
				$user = $tweets->statuses[$i]->user;
				$timestamp = $tweets->statuses[$i]->created_at;
				$displayName = $user->name;
				$userName = $user->screen_name;
				$profilePicture = $user->profile_image_url;
				$geo = $tweets->statuses[$i]->geo;
				$coordinates = $geo ? $geo->coordinates : null;

				/* echo 
					"<div>
						<h2>$displayName</h2>
						<h3>$username</h3>
						<img src='$profilePicture' alt='Avatar' />
						<p>$text</p>
						<p>".(is_array($coordinates) ? implode(" ", $coordinates) : "")."</p>
					</div>"; */
			}
        ?>

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