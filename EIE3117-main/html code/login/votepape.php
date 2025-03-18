<?php
$poll_id = $_POST['poll_id'];
$userid = $_POST['userid'];
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
    <form method="post" action="vote_controller.php">
                    <input type="hidden" name="poll_id" value="<?php echo $poll_id; ?>">
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                    <input type="hidden" name="creater" value="<?php echo $creater ;  ?>">
                    <input type="hidden" name="poll_title" value="<?php echo $poll_title; ?>">
                    <input type="hidden" name="starting_time" value="<?php echo $starting_time; ?>">
                    <input type="hidden" name="ending_time" value="<?php echo $ending_time; ?>">
                    <input type="hidden" name="description" value="<?php echo $description; ?>">

           <h3><?php echo $poll_title; ?></h3>
              <p>Creator: <?php echo $creater;  ?></p>
              <p>Poll Starting Time: <?php echo $starting_time;?></p>
              <p>Poll Ending Time: <?php echo $ending_time;?></p>
              <p><?php echo $description; ?></p>
              <input type="radio" name="choice1_i" value="<?php echo $choice1; ?>" required>
              <label for="<?php echo $choice1; ?>"><?php echo $choice1; ?></label><br>
              <input type="radio" name="choice2_i" value="<?php echo $choice2; ?>" required>
              <label for="<?php echo $choice2; ?>"><?php echo $choice2; ?></label><br>
              <input type="submit" value="vote">
    </form>
    <form action="MainContent.php">
        <input type="submit" value="back">
     </form>

</body>
</html>

