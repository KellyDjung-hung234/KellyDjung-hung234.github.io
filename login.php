  
<?php
session_start();
// GPT 內容, 同lecture內容一樣
// 檢查是否已登入
if(isset($_COOKIE['C_username'])){
    header("Location: MainContent.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取用戶名稱
    $username = $_POST['username'];
    $password = $_POST['Password'];

    $severname = "localhost";
    $DB_username ="root";
    $DB_password = "";
    $DB_name = "3117";
    @ $db = new mysqli($severname, $DB_username, $DB_password, $DB_name );
    
    if (mysqli_connect_errno()){
        echo 'Error: Could not connect to database.  Please try again later.'; 
        $_SESSION['stata'] = "connect_fail";
        header("Location: state.php");
        exit;      
    }
    
    //gpt太強了, ai 內容
    // 使用預處理語句來防止 SQL 注入
     $stmt = $db->prepare("SELECT password FROM users WHERE userid = ?"); //找與用戶輸入的userid相同的password
     $stmt->bind_param("s", $username);
     $stmt->execute();
     $stmt->store_result();

     if ($stmt->num_rows > 0) {  //如果找到的password結果數量 > 0
         $stmt->bind_result($result); 
         $stmt->fetch();
 
         // 驗證密碼
         if ($password == $result) {
             // 登錄成功
             // 儲存用戶名稱到 cookies（有效期 1 小時）
             setcookie('C_username', $username, time() + 3600);
    
             // 儲存用戶名稱到 session
             $_SESSION['username'] = $username;
         
             // 重定向到歡迎頁面
             header("Location: MainContent.php");
             exit();

         } else {
             // 密碼錯誤     
             $stmt->close();
             $db->close();
             $_SESSION['state'] = "login_fail";
             header("Location: state.php");

             }
         
     } else {
         // 用戶不存在
         $stmt->close();
         $db->close();
         $_SESSION['state'] = "login_fail";
         header("Location: state.php");
        }
     
}

?>    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PolyU online unwanted item giveaway system</title>
    <link rel="icon" href=
"https://media.geeksforgeeks.org/wp-content/cdn-uploads/gfg_200X200.png"
        type="image/x-icon" />
 <link rel="stylesheet" href="MyStyle.css">


</head>
<body>
    <h1>Welcome to the PolyU online voting system </h1>
    <h2>Login  </h2>
    
    <form method="post" action="">
       <label>UserID:</label>
       <input type="text" id="username" name="username" required><br><br>
       <label>Password:</label>
       <input type="password" id="Password" name="Password" required>
       <input type="button" value="show">
       <br>
       <br>
       <input type="submit" value="submit">
    </form>
    

    <br><a href="resiger.php">Don't have an acoount? click me to register!!</a>


</body>
</html>