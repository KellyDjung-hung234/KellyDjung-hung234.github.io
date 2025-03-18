<?php 
session_start();
$userid = $_SESSION["username"];
?>


<html>
<head>
      <!--ChoiceCreate function, GPT有BUG-->
      <script>
        function addOption() {

            const optionsDiv = document.getElementById('options');
            const newOption = document.createElement('div');
            newOption.className = 'option';
            newOption.innerHTML =  `
                <input type="text" name="options[]" required>
                <button type="button" onclick="removeOption(this)">刪除</button>
             `;
            optionsDiv.appendChild(newOption);
        }

        function removeOption(button) {
            button.parentElement.remove();
        }
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>content</title>
    
    <style>
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            text-align: left;
            border: none;
            outline: none;
            transition: 0.4s;
            position: relative; 
        }
        .panel {
            padding: 0 18px;
            display: none;
            background-color: white;
            overflow: hidden;
        }
        .active {
            background-color: #ccc;
        }
        .tablink {
            background-color: #aaa; 
            color: white; 
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            float: left; 
            margin-right: 10px; 
        }
        .tablink:hover {
            background-color: #555; 
        }
        .tabcontent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
            clear: both; 
        }
        .accordion-text {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
        .option {
            margin-bottom: 10px;
        }

    </style>

    </style>
</head>
<body>
    <div>
        <h1>Welcome to the voting system</h1>
    </div>
    <!--    Here is the navigation bar -->

<div style="clear: both; padding-bottom: 20px;">
    <button class="tablink" onclick="openPage('Home',this ,'#444')">Home</button>
    <button class="tablink" onclick="openPage('PollCreation', this, '#333')">PollCreation</button>
    <button class="tablink" onclick="openPage('PollList', this, '#333')">Poll list</button>
    <button class="tablink" onclick="openPage('MyPoll', this, '#333')">My Polls</button>
    <button class="tablink" onclick="openPage('MyProfile', this, '#333')">My Profile</button>
    <a href="logout.php" class="tablink" onclick="openPage('Logout',this,'#333'); return false;">
        Logout</a>
</div>

    
    

<div id="Home" class="tabcontent">
    <h1>Welcome to the voting system</h1>
    <p>In here you can :</p>
    <ul>
        <li>Create a Poll</li>
        <li>Vote to a poll</li>
        <li>View the data of the Poll</li>
    </ul>

</div>



<!--Here is the Poll creation funtion-->

<div id="PollCreation" class="tabcontent">

  <form method="post" action="poll_creation.php">

    <h1>Welcome to the Poll Creation function</h1>
    <p>please enter the details of your poll</p>

    <label>Poll Title:</label>
    <input type="text" id="PollTitle" name="PollTitle" required><br><br>
    <label>Poll Stating Time:</label>
    <input type="datetime-local"id ="PollStartingTime" name="PollStartingTime" required><br>
    <label>Poll Ending Time:</label>
    <input type="datetime-local" id="PollEndingTime" name="PollEndingTime"><br>

    <script>
    // 獲取今天的日期
    const today = new Date();
    
    // 格式化日期為 YYYY-MM-DDTHH:MM
    const formatDate = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}T00:00`; // 設定為當天的起始時間
    };

    // 設定開始時間的 min 屬性為今天
    document.getElementById('PollStartingTime').setAttribute('min', formatDate(today));
    
    // 當開始時間變更時更新結束時間的最小值
    document.getElementById('PollStartingTime').addEventListener('change', function() {
        const startDateTime = new Date(this.value);
        startDateTime.setDate(startDateTime.getDate() + 1); // 增加一天
        const endMinDateTime = formatDate(startDateTime);
        document.getElementById('PollEndingTime').setAttribute('min', endMinDateTime);
    });
</script>

    <label>Poll Description:</label>
    <input type="text" id="PollDescription" name="PollDescription" ><br><br>
    <label>Allow mutiple chioces:</label>
    <input type="radio" id="AllowMutipleChoice" name="AllowMutipleChoice"><br>


    <label>Choice one:</label>
    <input type="text" id="ChioceOne" name="ChioceOne" ><br>
    <label>Chioce Two</label>
    <input type="text" id="ChioceTwo" name="ChioceTwo" ><br>
 
    <div id="options">
    <button type="button" onclick="addOption()">ChoiceCreation</button><br>
    </div>
    <input type="submit" value="submit">
  </form>

</div>




<div id="PollList" class="tabcontent">
    <h3>View Results</h3>
    <p>View the results of the poll by selecting the poll you want to view:</p>
     
    <?php
    $severname = "localhost";
    $DB_username ="root";
    $DB_password = "";
    $DB_name = "3117";
    @ $db = new mysqli($severname, $DB_username, $DB_password, $DB_name);
    
    if (mysqli_connect_errno()){
        echo"Error : Could not connect to database.  Please try again later.'; ";
        exit();
    }

    $today = date('Y-m-d H:i:s');
    $query = "select * from poll where Ending_Time > '$today' ";
    $result = $db->query($query);
    $num_results = $result->num_rows;

    if ($num_results == 0){
       echo "There are not any poll now.";
    } else{
        for($i = 0; $i < $num_results; $i++){
            $row = $result->fetch_assoc(); 
            $pollid = "Poll" . $i; ?>  
            
            <button class="accordion" onclick="togglePanel('<?php echo $pollid; ?>', this)"><?php echo $row['Poll_Title']; ?>
                <span class="accordion-text">View</span></button>        

            <div id="<?php echo $pollid; ?>" class="panel"> 
              <h3><?php echo $row['Poll_Title']; ?></h3>
              <p>Creator: <?php echo $row['Creater'];  ?></p>
              <p>Poll Starting Time: <?php echo $row['Starting_Time'];?></p>
              <p>Poll Ending Time: <?php echo $row['Ending_Time'];?></p>
              <p><?php echo $row['Description']; ?></p>
              <ul>
                <li><?php echo $row['Choice1']; ?></li>
                <li><?php echo $row['Choice2']; ?></li>
              </ul>
            
               <form method="post" action="votepape.php">
                    <input type="hidden" name="poll_id" value="<?php echo $row['poll_id']; ?>">
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                    <input type="hidden" name="creater" value="<?php echo $row['Creater'];  ?>">
                    <input type="hidden" name="poll_title" value="<?php echo $row['Poll_Title']; ?>">
                    <input type="hidden" name="starting_time" value="<?php echo $row['Starting_Time']; ?>">
                    <input type="hidden" name="ending_time" value="<?php echo $row['Ending_Time']; ?>">
                    <input type="hidden" name="description" value="<?php echo $row['Description']; ?>">
                    <input type="hidden" name="choice1" value="<?php echo $row['Choice1']; ?>">
                    <input type="hidden" name="choice2" value="<?php echo $row['Choice2']; ?>">
                    <input type="submit" value="vote">
                </form>  
                    
                    
                <form method="post" action="view_result.php">
                <input type="hidden" name="poll_id" value="<?php echo $row['poll_id']; ?>">
                <input type="hidden" name="creater" value="<?php echo $row['Creater'];  ?>">
                <input type="hidden" name="poll_title" value="<?php echo $row['Poll_Title']; ?>">
                <input type="hidden" name="starting_time" value="<?php echo $row['Starting_Time']; ?>">
                <input type="hidden" name="ending_time" value="<?php echo $row['Ending_Time']; ?>">
                <input type="hidden" name="description" value="<?php echo $row['Description']; ?>">
                <input type="hidden" name="choice1" value="<?php echo $row['Choice1']; ?>">
                <input type="hidden" name="choice2" value="<?php echo $row['Choice2']; ?>">
                <input type="submit" value="view_Result"></form>


            </div>
    
    <?php } } 
    $db->close(); ?>
</div>


<div id="MyPoll" class="tabcontent">
    <h3>My Polls</h3>
    <p>View the polls you have created:</p><br>

    <?php
    @ $db = new mysqli($severname,  $DB_username, $DB_password, $DB_name );
    
    if (mysqli_connect_errno()) { 
      echo 'Error: Could not connect to database.  Please try again later.'; 
       exit();
     } 
     $query = "select * from poll where Creater = '".$userid."'";
     $result = $db->query($query); 
     $num_results = $result->num_rows;

     if ($num_results == 0) {
        echo "You don't create any polls. <br>"; 
    }else {
      for ($i = 0; $i <$num_results; $i++) {
        $row = $result->fetch_assoc(); 
        $pollid = "MyPoll_created" . $i; ?>
    
        <button class="accordion" onclick="togglePanel('<?php echo $pollid; ?>', this)">
            <?php echo $row['Poll_Title']; ?> <span class="accordion-text">View</span></button>
            
        <div id="<?php echo $pollid; ?>" class="panel"> 
            <h3><?php echo $row['Poll_Title']; ?> </h3>
            <p>Creator: <?php echo $row['Creater']; ?></p>
            <p>Poll Starting Time: <?php echo $row['Starting_Time']; ?></p>
    
            <p>Poll Ending Time: <?php echo $row['Ending_Time']; ?></p>
            

            <p><?php echo $row['Description']; ?></p>
            <ul>
                <li><?php echo $row['Choice1']; ?></li>
                <li><?php echo $row['Choice2']; ?></li>
            </ul>

            <form method="post" action="votepape.php">
                    <input type="hidden" name="poll_id" value="<?php echo $row['poll_id']; ?>">
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                    <input type="hidden" name="creater" value="<?php echo $row['Creater'];  ?>">
                    <input type="hidden" name="poll_title" value="<?php echo $row['Poll_Title']; ?>">
                    <input type="hidden" name="starting_time" value="<?php echo $row['Starting_Time']; ?>">
                    <input type="hidden" name="ending_time" value="<?php echo $row['Ending_Time']; ?>">
                    <input type="hidden" name="description" value="<?php echo $row['Description']; ?>">
                    <input type="hidden" name="choice1" value="<?php echo $row['Choice1']; ?>">
                    <input type="hidden" name="choice2" value="<?php echo $row['Choice2']; ?>">
                    <input type="submit" value="vote">
                </form>  
                    
                    
                <form method="post" action="view_result.php">
                <input type="hidden" name="poll_id" value="<?php echo $row['poll_id']; ?>">
                <input type="hidden" name="creater" value="<?php echo $row['Creater'];  ?>">
                <input type="hidden" name="poll_title" value="<?php echo $row['Poll_Title']; ?>">
                <input type="hidden" name="starting_time" value="<?php echo $row['Starting_Time']; ?>">
                <input type="hidden" name="ending_time" value="<?php echo $row['Ending_Time']; ?>">
                <input type="hidden" name="description" value="<?php echo $row['Description']; ?>">
                <input type="hidden" name="choice1" value="<?php echo $row['Choice1']; ?>">
                <input type="hidden" name="choice2" value="<?php echo $row['Choice2']; ?>">
                <input type="submit" value="view_Result"></form>
    
        </div>
    <?php } } 
    $db->close();
    ?>

    <p>View polls that you voted: </p><br>
    <?php
    @ $db = new mysqli($severname,  $DB_username, $DB_password, $DB_name );
    
    if (mysqli_connect_errno()) { 
      echo 'Error: Could not connect to database.  Please try again later.'; 
       exit();
     } 
     $query = "select * from poll_record where Voter = '".$userid."'";
     $result = $db->query($query); 
     $num_results = $result->num_rows;

     if ($num_results == 0) {
        echo "You don't vote any polls. <br>"; 
    }else {
      for ($i = 0; $i <$num_results; $i++) {
        $row = $result->fetch_assoc(); 
        $pollid = "MyPoll_voted" . $i; ?>
    
        <button class="accordion" onclick="togglePanel('<?php echo $pollid; ?>', this)">
            <?php echo $row['Poll_Title']; ?> <span class="accordion-text">View</span></button>
            
        <div id="<?php echo $pollid; ?>" class="panel"> 
            <h3><?php echo $row['Poll_Title']; ?> </h3>
            <p>Creator: <?php echo $row['Creater']; ?></p>
            <p>Poll Starting Time: <?php echo $row['Starting_Time']; ?></p>
    
            <p>Poll Ending Time: <?php echo $row['Ending_Time']; ?></p>
            

            <p><?php echo $row['Description']; ?></p>
            <p>Your choice:</p>
            <p><?php echo $row['Choice1']; ?></p>
            <p><?php echo $row['Choice2']; ?></p>



            <form method="post" action="votepape.php">
                    <input type="hidden" name="poll_id" value="<?php echo $row['poll_id']; ?>">
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                    <input type="hidden" name="creater" value="<?php echo $row['Creater'];  ?>">
                    <input type="hidden" name="poll_title" value="<?php echo $row['Poll_Title']; ?>">
                    <input type="hidden" name="starting_time" value="<?php echo $row['Starting_Time']; ?>">
                    <input type="hidden" name="ending_time" value="<?php echo $row['Ending_Time']; ?>">
                    <input type="hidden" name="description" value="<?php echo $row['Description']; ?>">
                    <input type="hidden" name="choice1" value="<?php echo $row['Choice1']; ?>">
                    <input type="hidden" name="choice2" value="<?php echo $row['Choice2']; ?>">
                    <input type="submit" value="vote">
                </form>  
                    
                    
                <form method="post" action="view_result.php">
                <input type="hidden" name="poll_id" value="<?php echo $row['poll_id']; ?>">
                <input type="hidden" name="creater" value="<?php echo $row['Creater'];  ?>">
                <input type="hidden" name="poll_title" value="<?php echo $row['Poll_Title']; ?>">
                <input type="hidden" name="starting_time" value="<?php echo $row['Starting_Time']; ?>">
                <input type="hidden" name="ending_time" value="<?php echo $row['Ending_Time']; ?>">
                <input type="hidden" name="description" value="<?php echo $row['Description']; ?>">
                <input type="hidden" name="choice1" value="<?php echo $row['Choice1']; ?>">
                <input type="hidden" name="choice2" value="<?php echo $row['Choice2']; ?>">
                <input type="submit" value="view_Result"></form>
    
        </div>
    <?php } } 
    $db->close();
    ?>
         
    
    <h3>View Results</h3>
    <p>View the results of the poll by selecting the poll you want to view:</p>

</div>






<div id="MyProfile" class="tabcontent">
    <h3>My Profile</h3>
    <p>View your profile and edit it:</p>
    
    <?php
    @ $db = new mysqli($severname,  $DB_username, $DB_password, $DB_name );
    
    if (mysqli_connect_errno()) { 
      echo 'Error: Could not connect to database.  Please try again later.'; 
     }  
     $query = "SELECT * FROM users WHERE userid = '".$userid."'";
     $result = $db->query($query);
 
     if ($result) {
             $row = $result->fetch_assoc();
             if (!empty($row['profileimage'])): ?>
                <img src="<?php echo htmlspecialchars($row['profileimage']); ?>" alt="Profile Image" style="max-width: 200px; max-height: 200px;">
            <?php else: ?>
                <p>沒有上傳頭像。</p>
            <?php endif; ?>
            <a href="edit_profile.php">edit image</a>
            <?php
             echo '<p>user ID: ' . htmlspecialchars($row['userid']) . '</p>';
             echo '<p>user Nickname: ' . htmlspecialchars($row['nick_name']) . '</p>';
             echo '<p>email: ' . htmlspecialchars($row['email']) . '</p>'; ?>
             
        <?php } else {
   
         echo 'Error: Could not execute query. Please try again later.';
     }
    $db->close(); ?>

</div>

<div>
    Content information<br>
    Email:whatshouldIeat@gmail.com<br>
    Phone Namber:12345678<br>
</div>

<script>
    function openPage(pageName, elmnt, color) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = color;
        }
        document.getElementById(pageName).style.display = "block";
    }

    function togglePanel(panelId, elmnt) {
        var panel = document.getElementById(panelId);
        var textElement = elmnt.querySelector('.accordion-text');
        if (panel.style.display === "block") {
            panel.style.display = "none";
            elmnt.style.backgroundColor = "#eee"; 
            textElement.textContent = "View";
        } else {
            panel.style.display = "block";
            elmnt.style.backgroundColor = "#333";
            textElement.textContent = "Regain";
        }
    }
</script>

</body>
</html>
