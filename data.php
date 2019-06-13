<?php

    // o--------------------------------------------------------
    // | Input & Settings
    // o--------------------------------------------------------

    // These variables are sent from Unity, we access them via
    // $_POST and make sure to santitize the input to mysql.

    $game     = mysqli_real_escape_string($_POST['game']);
    $player   = mysqli_real_escape_string($_POST['playerName']);
    $score    = mysqli_real_escape_string($_POST['score']);

    // These settings define where the server is located, and
    // which credentials we use to connect to that server.

    $server   = "localhost";
    $username = "appAndroid";
    $password = "JO3XILG2QZUy";

    // This is the database and table we are going to access in
    // the mysql server. In this example, we assume that we have
    // the table 'highscores' in the database 'gamedb'.

    $database = "PlayersAccounts";
    $table    = "highscores";

    // These are the MySQL queries that we are going to use when
    // we store our new score, and return our top 10 players.

    $insert   = "INSERT INTO $table (game, player, score)
                 VALUES ('$game', '$player', '$score')";

    $select   = "SELECT * FROM $table WHERE game='$game'
                 ORDER BY score DESC LIMIT 10";

    // o--------------------------------------------------------
    // | Access database
    // o--------------------------------------------------------

    // Connect to the server with our settings defined above.

    $connection = mysql_connect($server, $username, $password);

    // 1. Select the database to work with.
    // 2. Insert our new player score.
    // 3. Select the top 10 players.

    $result = mysql_select_db($database, $connection);
    $result = mysql_query($insert, $connection);
    $result = mysql_query($select, $connection);

    // Finally, go through top 10 players and return the result
    // back to Unity. The output format for each line will be:
    // {game}:{player}:{score}

    while ($row = mysql_fetch_array($result)){
      while ( $row = $result->fetch_assoc())  {
      $dbdata[]=$row;
      }
         }
           echo json_encode($dbdata);
    // Close the connection, we're done here.

    mysql_close($connection);
?>
