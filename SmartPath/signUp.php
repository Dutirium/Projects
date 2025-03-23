<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <style>
/* General Body Styling */
body 
{
    font-family: Arial, sans-serif;
    background-color: #121212; /* Dark background */
    color: #f0f0f0; /* Light text for contrast */
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: fit-content;
    flex-direction: column;
}

/* Main Container */
.main {
    background-color: #1f1f1f; /* Slightly lighter dark background */
    border-radius: 8px;
    padding: 40px;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Subtle shadow */
    text-align: center;
    height: fit-content;
}

/* Title Styling */
h1 
{
    color: #ffffff;
    font-size: 28px;
    margin-bottom: 20px;
}

/* Input Fields Styling */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    background-color: #333; /* Dark background for inputs */
    color: #e0e0e0; /* Light text color */
    border: 1px solid #444; /* Dark border */
    border-radius: 4px;
}

/* Input Fields Focus Styling */
input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus 
{
    border-color: #00e676; /* Green border when focused */
    outline: none;
}

/* Submit Button Styling */
button 
{
    background-color: #00e676; /* Green background */
    color: #121212; /* Dark text for contrast */
    padding: 14px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

/* Button Hover Effect */
button:hover {
    background-color: #00c853; /* Darker green on hover */
}

/* Links Styling */
a {
    color: #00e676; /* Green color for links */
    text-decoration: none;
}

/* Links Hover Effect */
a:hover {
    text-decoration: underline;
}

/* Already a member text */
p {
    color: #bbbbbb; /* Light gray text */
    font-size: 14px;
    margin-top: 20px;
}

/* Error Styling (if needed) */
#error-message {
    color: #ff3b30; /* Red color for error */
    font-size: 14px;
    text-align: center;
    margin-top: 10px;
}

</style>
</head>
<body>
<div class="main">
    <h1>Sign Up</h1>
    <form method="POST" action="">
        Enter your email: <br>
        <input type="email" name="email" required><br><br>
        Create username: <br>
        <input type="text" name="username" required><br>
        <p id="pu"></p>
        Enter your course: <br>
        <input type="text" name="branch"><br><br>
        Enter your phone number: <br>
        <input type="text" name="pno"><br><br>
        Enter your current year: <br>
        <input type="text" name="year" id=""><br><br>
        Create your password:<br>
        <input type="password" name="password" required><br><br>
        Re-enter your password:<br>
        <input type="password" name="confirm_password" required><br><br>
        <button type="submit" name="signup">Signup</button><br><br>
        Already a member? <a href="login.php"><b>LogIn</b></a>
    </div>

<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "smartpath");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['signup'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $branch=$_POST["branch"];
    $pno=$_POST["pno"];
    $year=$_POST["year"];
    $username=$_POST["username"];
    // Check if passwords match
    if($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!');</script>";
        exit();
    }

    
    $check_query = "SELECT * FROM studentinfo WHERE email = '$email'";
    $result1 =mysqli_query($conn, $check_query);
    
    $check_query1 = "SELECT * FROM studentinfo WHERE username = '$username'";
    $result2 =mysqli_query($conn, $check_query1);
    if(mysqli_num_rows($result1)>0) 
    {
       echo "<script>alert('Email already exists! Please Login instead.');</script>";
    } 
    else if (mysqli_num_rows($result2)>0)
    {
       echo "<script>alert('Username already exists!');</script>";
    }
    else {
  // Insert new user
        $insert_query = "INSERT INTO studentinfo (email,password,course,phoneNumber,year,username) VALUES ('$email', '$password','$branch','$pno','$year','$username')";
    
        if(mysqli_query($conn, $insert_query)) 
        {
            echo "<script>alert('Registration successful!');
                  window.location.href='login.php';</script>";
        } 
        else 
        {
            echo "<script>alert('Error occurred. Please try again.');</script>";
        }
    }
}
?>

</body>
</html>