<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="MyStyle.css">

</head>
<body>
    <form method="post" action="" enctype="multipart/form-data">
        <label><H1>Login information <br>



        </h1></label>
        <label>login id :</label>
        <input type="text" id="UserId" name="UserID" required><br><br>
        <label>password</label>
        <input type="password" id="Password" name="Password" required><br><br>

        <label>Password Confirm  </label>
        <input type="password" id="PasswordConfirm" name="PasswordConfirm" required><br><br>
        
        <label><h1>Personal information</h1></label>
        
        <label>nick name </label>
        <input type="text" id="Nickname" name="Nickname" required><br><br>
        <label>email</label>

        <input type="email" id="email" name="email" required><br><br>
        <label for="file"> profile image</label>
        <input type="file" id="ProfileImage" name="ProfileImage" accept="image/*" required>

        <br><br>
        <input type="submit" value="submit">


    </form>
    <a href="login.php">Return</a><br>

<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['UserID'];
    $password = $_POST['Password'];
    $password2 = $_POST['PasswordConfirm'];
    $nickname = $_POST['Nickname'];
    $email = $_POST['email'];
    
    // 檢查上傳的文件
    if (isset($_FILES['ProfileImage']) && $_FILES['ProfileImage']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['ProfileImage']['tmp_name'];
        $fileName = $_FILES['ProfileImage']['name'];
        $fileSize = $_FILES['ProfileImage']['size'];
        $fileType = $_FILES['ProfileImage']['type'];

        // 檢查文件類型
        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($fileType, $allowedFileTypes)) {
            // 設定目標路徑
            $uploadFileDir = './uploads/';

            // 檢查目錄是否存在，若不存在則創建
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            $destPath = $uploadFileDir . basename($fileName);

            // 移動上傳的文件
            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                echo "文件上傳失敗！";
                exit();
            }
        } else {
            echo "不支持的文件類型！";
            exit();
        }
    } else {
        echo "上傳錯誤！";
        exit();
    }

    // 檢查必填字段
    if (!$userid || !$password || !$nickname || !$email) {
        $_SESSION['state'] = "have_empty"; 
        header("Location: state.php");
        exit();
    }

    // 檢查密碼確認
    if ($password != $password2) {
        $_SESSION['state'] = "password_wrong";
        header("Location: state.php");
        exit();
    }

    // 數據庫連接
    $servername = "localhost";
    $DB_username = "root";
    $DB_password = "";
    $DB_name = "3117";
    $db = new mysqli($servername, $DB_username, $DB_password, $DB_name);

    if ($db->connect_errno) {
        $_SESSION['state'] = "connect_fail";
        header("Location: state.php");
        exit();
    }

    // 密碼哈希

    // 插入用戶數據
    $query = "INSERT INTO users (userid, password, nick_name, email, profileimage) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssss", $userid, $password, $nickname, $email, $destPath);

    if ($stmt->execute()) {
        $_SESSION['state'] = "resiger_sucess";
        header("Location: state.php");
        exit();
    } else {
        $_SESSION['state'] = "resiger_fail";
        header("Location: state.php");
          
    }

    $stmt->close();
    $db->close();
}
?>
    
</body>
</html>