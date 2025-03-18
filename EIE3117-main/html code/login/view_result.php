<?php
$poll_id = $_POST['poll_id'];
$creater = $_POST['creater'];
$poll_title = $_POST['poll_title'];
$starting_time = $_POST['starting_time'];
$ending_time = $_POST['ending_time'];
$description = $_POST['description'];
$choice1 = $_POST['choice1'];
$choice2 = $_POST['choice2'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
           <h3><?php echo $poll_title; ?></h3>
              <p>Creator: <?php echo $creater;  ?></p>
              <p>Poll Starting Time: <?php echo $starting_time;?></p>
              <p>Poll Ending Time: <?php echo $ending_time;?></p>
              <p><?php echo $description; ?></p>

            <?php
            $severname = "localhost";
            $DB_username ="root";
            $DB_password = "";
            $DB_name = "3117";
            @ $db = new mysqli($severname,$DB_username,$DB_password,$DB_name);
            if (mysqli_connect_errno()){
                echo "connect_error";
                $_SESSION['state'] = "connect_fail";
                header("Location: state.php");
                exit();
              }
            
            $query = "select * from poll_record where choice1 ='$choice1' AND poll_id ='$poll_id'" ;
            $result = $db->query($query);
            $num_choice1 = $result ? $result->num_rows : 0;

            $query = "select * from poll_record where choice2 ='$choice2' AND poll_id ='$poll_id'";
            $result = $db->query($query);
            $num_choice2 = $result ? $result->num_rows : 0;
            
            $db ->close();
            ?>
              <ul>
                <li><?php echo $choice1.": " . $num_choice1 ." people selected"; ?></li>
                <li><?php echo $choice2.": " . $num_choice2 ." people selected"; ?></li>
              </ul>
              
              <form action="MainContent.php">
              <input type="submit" value="back"></form>


</body>
</html>