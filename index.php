<?php
$submit = false;
$server = "localhost";
$username = "root";
$password = "";
$database = "anurag_demo";
$isRegistered = false;
// Establish the database connection
$con = new mysqli($server, $username, $password, $database);

// Check connection
if ($con->connect_error) 
{
    die("Connection failed: " . $con->connect_error);
}

// Retrieve and sanitize input data

$name = isset($_POST['name']) ? $_POST['name'] : '';
$registration = isset($_POST['Registration']) ? $_POST['Registration'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$college = isset($_POST['college']) ? $_POST['college'] : '';
$branch = isset($_POST['branch']) && $_POST['branch'] !== 'none' ? $_POST['branch'] : '';
$year = isset($_POST['year']) && $_POST['year'] !== 'none' ? $_POST['year'] : '';
$sem = isset($_POST['sem']) && $_POST['sem'] !== 'none' ? $_POST['sem'] : '';

// Validate inputs
if (!empty($name) && !empty($registration) && !empty($email) && !empty($phone) &&
    !empty($college) && !empty($branch) && !empty($year) && !empty($sem)) 
    {
    
    // Prepare the SQL statement
    $sql = "INSERT INTO `sing_form` (`name`, `registration no.`, `email`, `phone`, `college`, `branch`, `year`, `sem`, `date`) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP())";

    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    // Bind parameters
    $stmt->bind_param("ssssssss", $name, $registration, $email, $phone, $college, $branch, $year, $sem);

    // Execute the statement
    if ($stmt->execute()) {
        // echo "Successfully submitted";
        $submit = true;
        $isRegistered = true;
    } else {
        echo " ERROR: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$con->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">    


</head>

<body>

    <!-- <div id="start">

        <button id="asguestbtn">asGeust</button>
        <button id="loginbtn">Login</button>
        <button id="signinbtn">Signin</button>

    </div> -->

     <!-- Student Details -->   

    <?php
    if(!$isRegistered)
    {
    ?>
    <div id="sign">
        <form action="index.php" method="post" id="signinform">

            <a href="https://vignan.ac.in" target="main"><img src="https://www.vignan.ac.in/images/LOGO_change.jpg"
                    width="300px"></img></a><br>
            <label for="name">Enter Your Name:</label> <br>
            <input type="text" id="name" name="name" placeholder="your Name" required hidden><br>

            <label for="regno">Registration No:</label> <br>
            <input type="text" id="regno" name="Registration" placeholder="Registration No" required><br>

            <label for="mail">Email: </label><br>
            <input type="email" id="mail" name="email" placeholder="@gmail.com" required><br>

            <label for="mail">Phone: </label><br>
            <input type="phone" id="phone" name="phone" placeholder="123-456-789-0" required><br>


            <label for="college">College: </label> <br>
            <input type="text" id="college" name="college" placeholder="College Name" required><br>


            <label for="branch">Select Branch:</label><br>
            <select name="branch" id="branch">
                <option value="none"></option>
                <option value="ECE">ECE</option>
                <option value="CSE">CSE</option>
                <option value="ITE">ITE</option>
                <option value="AUE">AUE</option>
                <option value="MEE">MEE</option>
                <option value="BME">BME</option>
                <option value="BTE">BTE</option>
                <option value="CEE">CEE</option>
                <option value="CHE">CHE</option>
                <option value="FDE">FDE</option>
            </select><br>

            <label for="year">Select Year:</label><br>
            <select name="year" id="year">
                <option value="none"></option>
                <option value="1st year">1st year</option>
                <option value="2nd year">2nd year</option>
                <option value="3rd year">3rd year</option>
                <option value="4th year">4th year</option>
            </select><br>

            <label for="sem">Select Semester:</label><br>
            <select name="sem" id="sem">
                <option value="none"></option>
                <option value="1st sem">1st sem</option>
                <option value="2nd sem">2nd sem</option>
            </select><br>

            <button type="submit" id="verifySignin">Submit</button>
        </form>

        <?php
        
        if($submit == true)
        {
        echo "<h1 id = 'submitted'> Successfully submitted </h1>";
        }

       ?>
    </div>
    <?php
    }
    ?>



<!-- create the ID passwords -->

    <?php 
    if ($isRegistered) 
    {
    ?>
    <div id="loginForm">
        <form action="index.php" method="post">
            <a href="https://vignan.ac.in" target="main"> 
                <img src="https://www.vignan.ac.in/images/LOGO_change.jpg" width="300px">
            </a><br>
            <label for="username"><b>Username:</b></label>
            <input type="text" id="username" name="username" placeholder="Username" required ><br>

            <label for="password"><b>Password:</b></label>
            <input type="password" id="password" name="password" placeholder="Password" required><br>

            <label for="password"><b>Conform Password:</b></label>
            <input type="password" id="password" name="conform_password" placeholder="Conform Password" required><br>

            <button type="submit" id="login">Next</button><br>
            
        </form>
    </div> 
    <?php
    }
    ?>



  <!-- Loing -->

    <!-- <?php 
    if (!$isRegistered) {
    ?>
    <div id="loginForm">
        <form action="index.php" method="post">
            <a href="https://vignan.ac.in" target="main"> 
                <img src="https://www.vignan.ac.in/images/LOGO_change.jpg" width="300px">
            </a><br>
            <label for="username"><b>Username:</b></label>
            <input type="text" id="username" name="username" placeholder="Username" required><br>

            <label for="password"><b>Password:</b></label>
            <input type="password" id="password" name="password" placeholder="Password" required><br>

            <button type="submit" id="login">Login</button><br>
            
            <label>
                <input type="checkbox" id="remember" checked="checked" required> Remember me
            </label><br>

            <button type="button" id="cancelbtn">Cancel</button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </form>
    </div> 
    <?php
    }
    ?> -->

    <!-- home page -->

    <!-- <div id="vegnonveg">

        <div onclick="vegitem()" id="b">
            <div id="m">
                <div id="c">
                </div>
                <div id="c-text">Veg</div>
            </div>
        </div>

        <div onclick="nonvegitem()" id="b1">
            <div id="m1">
                <div id="c1">
                </div>
                <div id="c1-text">Non-Veg</div>
            </div>
        </div>
    </div>  -->


   

    <script src="index.js">

    </script>
    <!-- INSERT INTO `sing_form` (`name`, `registration no.`, `email`, `phone`, `college`, `branch`, `year`, `sem`, `date`)
    VALUES ('gyandeep kumar', '221fa05230', 'gyandeep@gmail.com', '1234567890', 'vignan', 'ece', '3', '1st',
    CURRENT_DATE()); -->

</body>

</html>