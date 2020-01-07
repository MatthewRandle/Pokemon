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
        "geocode" => "53.8175,-3.0357,250mi",
        "count" => "100",
        "tweet_mode" => "extended"));
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab:700&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="stylesheets/css/Index.css?ts=<?=time()?>" />
        <link rel="stylesheet" type="text/css" href="stylesheets/css/Navbar.css" />
        <link rel="stylesheet" type="text/css "href="stylesheets/css/Reset.css" />
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" integrity="sha384-REHJTs1r2ErKBuJB0fCK99gCYsVjwxHrSU0N7I1zl9vZbggVJXRMsv/sLlOAGb4M" crossorigin="anonymous">
    </head>

    <body>
        <div class="navbar">
            <p>Pokemon</p>
            <p>Sign In with Twitter</p>
        </div>

        <div id="distance--hidden">
            <p></p>
        </div>

        <div class="timeline">
            <?php            
                $locations = array();

                for($i = 0; $i < count($tweets->statuses); $i++) {
                    if(isset($tweets->statuses[$i]->retweeted_status)) continue;

                    
                    $text = $tweets->statuses[$i]->full_text;
                    $user = $tweets->statuses[$i]->user;
                    $retweets = $tweets->statuses[$i]->retweet_count;
                    $likes = $tweets->statuses[$i]->favorite_count;
                    $timestamp = $tweets->statuses[$i]->created_at;
                    $displayName = $user->name;
                    $profilePicture = $user->profile_image_url;
                    $place = $tweets->statuses[$i]->place;
                    $coordinates = $place ? $place->bounding_box->coordinates[0][0] : null;
                    
                    //if tweet has coordinates, add them to the locations array
                    if(isset($coordinates[0]) && isset($coordinates[1])) {
                        $locations[] = array(
                            "lat" => $coordinates[1], 
                            "long" => $coordinates[0],
                            "username" => $displayName,
                            "text" => $text,
                            "profilePicture" => $profilePicture
                        );
                    }

                    echo 
                        "<div class='tweet'>
                            <div><img src='$profilePicture' alt='Avatar' /></div>

                            <div class='tweet_content'>
                                <h2 class='tweet_username'>$displayName</h2>

                                <p class='tweet_text'>$text</p>

                                <div class='tweet_bottom'>
                                    <p><i class='fas fa-retweet'></i> $retweets</p>
                                    <p><i class='fas fa-heart'></i> $likes</p>
                                </div>
                            </div>
                        </div>";

                        /* "<div>
                            <h2>$displayName</h2>
                            <h3>@$username</h3>
                            <img src='$profilePicture' alt='Avatar' />
                            <p>$text</p>
                            <p>".(is_array($coordinates) ? implode(" ", $coordinates) : "")."</p>
                        </div>"; */
                }
            ?>
        </div>		

        <div id="map">
            
        </div>

        <script type="text/javascript">var locations = <?php echo json_encode($locations); ?>;</script>
        <script src="./index.js" type="text/javascript"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCNLjoxj2VIWiZJE_54MRL0pO-ruGVB7B4&callback=initMap&libraries=geometry" async defer></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    </body>
</html>