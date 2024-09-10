<?php
$submit = false;
$pass = false;

$server = "localhost";
$username = "root";
$password = "";
$database = "student";

// Create connection
$con = new mysqli($server, $username, $password, $database);

// Check connection
if ($con->connect_error) 
{
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['username'], $_POST['password'])) 
{
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare and bind
    $stmt = $con->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows are returned
    if ($result->num_rows > 0) 
    {
        // User is authenticated, redirect to home page
        $submit = true;
        header("Location: homePage.php");
        exit();
    } 
    else 
    {
        $pass = true;
    }

    $stmt->close();
}

$con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div id="loginForm">
        <form action="login.php" method="post">
            <a href="https://vignan.ac.in" target="main">
                <img src="https://www.vignan.ac.in/images/LOGO_change.jpg" width="300px">
            </a><br>
            <label for="username"><b>Username:</b></label>
            <input type="text" id="username" name="username" placeholder="Username" required><br>

            <label for="password"><b>Password:</b></label>
            <input type="password" id="password" name="password" placeholder="Password" required><br>
            <?php
            if($pass)
            {
                echo "<p id='passtext'>Incorrect password. Try again. </p>";
            }
            ?>
            <button type="submit" id="login">Login</button><br>

            <label>
                <input type="checkbox" id="remember" checked="checked" required> Remember me
            </label><br>

            <button type="button" id="cancelbtn" onclick="cancel()">Cancel</button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </form>
    </div>
    <script>
        function cancel()
        {
            window.location.href = 'index.php';s
        }
    </script>

</body>

</html>