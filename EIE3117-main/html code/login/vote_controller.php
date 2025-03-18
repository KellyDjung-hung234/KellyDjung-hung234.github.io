
<?PHP
session_start();
      $severname = "localhost";
      $DB_username ="root";
      $DB_password = "";
      $DB_name = "3117";
      $poll_id = $_POST['poll_id'];
      $userid = $_POST['userid'];
      $creater = $_POST['creater'];
      $poll_title = $_POST['poll_title'];
      $starting_time = $_POST['starting_time'];
      $ending_time = $_POST['ending_time'];
      $description = $_POST['description'];
      $choice1_i = isset($_POST['choice1_i']) ? $_POST['choice1_i'] : NULL;
      $choice2_i = isset($_POST['choice2_i']) ? $_POST['choice2_i'] : NULL;
      

      @ $db = new mysqli($severname, $DB_username, $DB_password, $DB_name);

      if (mysqli_connect_errno()){
        echo "connect_error";
        $_SESSION['state'] = "connect_fail";
        header("Location: state.php");
        exit();
      }

        $query = "INSERT INTO poll_record (poll_id, Voter, Creater, Poll_Title, Starting_Time, Ending_Time, Description, Choice1, Choice2)
                     VALUES ('".$poll_id."','".$userid."','".$creater."','".$poll_title."',
                     '".$starting_time."','".$ending_time."','".$description."',
                     '".$choice1_i."','".$choice2_i."')";

        $result = $db ->query($query);
        if($result){
            $db->close();
            $_SESSION['state'] = "vote_success";
            header("Location: state.php");

        } else {
            $db->close();
            $_SESSION['state'] = "vote_fail";
            header("Location: state.php");

        }


    ?>
