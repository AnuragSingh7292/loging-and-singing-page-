<?php
$submit = false;
$passKey = false;
$server = "localhost";
$username = "root";
$password = "";
$database = "student";

// Create connection
$con = new mysqli($server, $username, $password, $database);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['username'], $_POST['password'], $_POST['confirm_password'])) 
{
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $conPass = $_POST['confirm_password'];

    if ($pass === $conPass) 
    {

        $stmt = $con->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $pass);

        // Execute the statement
        if ($stmt->execute()) 
        {
            $submit = true;
        } 
        else 
        {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } 
    else 
    {
        $passKey = true;
    }
}

// Close connection
$con->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="userpsw.css">
    
</head>
<body>
<div id="loginForm">

        <form action="userpsw.php" method="post">
            <a href="https://vignan.ac.in" target="main"> 
                <img src="https://www.vignan.ac.in/images/LOGO_change.jpg" width="300px">
            </a><br>
            <label for="username"><b>Username:</b></label>
            <input type="text" id="username" name="username" placeholder="Username" required ><br>

            <label for="password"><b>Password:</b></label>
            <input type="password" id="password" name="password" placeholder="Password" required><br>

            <label for="password"><b>Confirm Password:</b></label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required><br>
            <?php
            if($passKey)
            {
                echo "<p id='passtext'>password do not matched with confirm password. Try again </p>";
            }
            ?>
            <button type="submit" id="login">Next</button><br>

            <?php
            if($submit)
            {
                header("location: login.php");
            }
            ?>
            
        </form>
    </div> 

    <script src="index.js"></script>
</body>
</html>