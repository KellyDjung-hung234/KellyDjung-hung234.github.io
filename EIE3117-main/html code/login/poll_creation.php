<?php
session_start();
$username = $_COOKIE['C_username'];
$poll_title = $_POST['PollTitle'];
$starting_time = $_POST['PollStartingTime'];
$ending_time = $_POST['PollEndingTime'];
$description = $_POST['PollDescription'];
$choice1 = $_POST['ChioceOne'];
$choice2 = $_POST['ChioceTwo'];


    $severname = "localhost";
    $DB_username ="root";
    $DB_password = "";
    $DB_name = "3117";
    @ $db = new mysqli($severname, $DB_username, $DB_password, $DB_name );
    
    if (mysqli_connect_errno()) { 
        echo 'Error: Could not connect to database.  Please try again later.'; 
        echo '<script>setTimeout(function() { window.location = "login.php"; }, 4000);</script>';  
        exit();
       } 

    if (!$poll_title || !$choice1 ||!$choice2 ) { 
         echo "You have not entered all the required details.<br />"
            ."Please go back and try again.";
         echo '<script>setTimeout(function() { window.location = "MainContent.php"; }, 4000);</script>';
         exit();
        } 
             
    else{
      $query = "INSERT INTO poll (Creater,Poll_Title,Starting_Time,Ending_Time,
                Description,Choice1,Choice2) 
      values  ('".$username."','".$poll_title."','".$starting_time."','".$ending_time."',
                '".$description."','".$choice1."','".$choice2."')";
      $result = $db ->query($query);

      if ($result){
        $db->close();
        echo "The poll create successful.";
        echo '<script>setTimeout(function() { window.location = "MainContent.php"; }, 4000);</script>';
        exit();

      } else {
        $db->close();
        echo "The poll creation failed. The input data have something wrong.";
        echo '<script>setTimeout(function() { window.location = "MainContent.php"; }, 4000);</script>';
        exit();
      }

    }





?>