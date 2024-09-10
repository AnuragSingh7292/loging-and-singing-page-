<?php
$submit = false;
$server = "localhost";
$username = "root";
$password = "";
$database = "student";
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
    $sql = "INSERT INTO `student_details` (`name`, `registration no.`, `email`, `phone`, `college`, `branch`, `year`, `sem`, `date`) 
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
    <link rel="stylesheet" href="userDetails.css">
</head>

<body>

    <div id="sign">

        <form action="userDetails.php" method="post" id="signinform">
            <a href="https://vignan.ac.in" target="main"><img src="https://www.vignan.ac.in/images/LOGO_change.jpg"
                    width="300px"></img></a><br>
            <label for="name">Enter Your Name:</label> <br>
            <input type="text" id="name" name="name" placeholder="your Name" required><br>

            <label for="regno">Registration No:</label> <br>
            <input type="text" id="regno" name="Registration" placeholder="Registration No" required><br>

            <label for="mail">Email: </label><br>
            <input type="email" id="mail" name="email" placeholder="@gmail.com" required><br>

            <label for="mail">Phone: </label><br>
            <input type="phone" id="phone" name="phone" placeholder="123-456-789-0" required><br>


            <label for="college">College: </label> <br>
            <input type="text" id="college" name="college" placeholder="College Name" required><br>


            <label for="branch">Select Branch:</label><br>
            <select name="branch" id="branch" required>
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
            <select name="year" id="year" required>
                <option value="none"></option>
                <option value="1st year">1st year</option>
                <option value="2nd year">2nd year</option>
                <option value="3rd year">3rd year</option>
                <option value="4th year">4th year</option>
            </select><br>

            <label for="sem">Select Semester:</label><br>
            <select name="sem" id="sem" required>
                <option value="none"></option>
                <option value="1st sem">1st sem</option>
                <option value="2nd sem">2nd sem</option>
            </select><br>

            <button type="submit" id="verifySignin">Submit</button>
        </form>

        <?php
        if($submit == true)
        {
            header("Location: userpsw.php");
        }
       ?>
    </div>
    <script src="index.js"></script>
</body>

</html>