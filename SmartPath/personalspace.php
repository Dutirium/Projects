<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal room</title>
    <?php session_start(); ?>
    <link rel="stylesheet" href="personalspace.css">
</head>
<body>
  <div class="prsnlroom">
    PERSONAL ROOM

  </div>
    <div  id="uname"></div>
    
      <div class="menubar">
        <div class="image"><img src="images/insta.jpg" alt="" ></div>
        <div class="image"><img src="images/facebook.jpg" alt=""></div>
        <div class="image"><img src="images/twitter.jpg" alt=""></div>
      </div>
      <br>
   <div class="main">
      <div class="container">
      <a href="folder/performance.php"><div class="flexbox">See where you stand</div></a>
      <a href="folder/database.php"> <div class="flexbox">Create your database</div></a>
       <a href="folder/Cspecific.php"><div class="flexbox">Compare to someone specific</div></a> 
      </div>
       <br>
    
      <div class="container">
        <a href="folder/leaderboard.php"><div class="flexbox">Leader Board</div></a>
         <a href="folder/studyplanner.php"><div class="flexbox">Study Planner</div></a>
        <!-- <div class="flexbox">Flash cards</div>  -->
      </div>
      </body>
      </html>
  
      <div class="streak" id="streak"></div>
    </div>
  <?php
// Get current date
$currentDate = new DateTime();

$email = $_SESSION["email"]; // Replace with the user's email from the login system

// Generate a cookie name based on the email
$cookieName = 'login_streak_' . md5($email);

$conn=mysqli_connect("localhost","root","","smartpath");

$query="select username from studentinfo where email=\"$email\";";

$result=mysqli_query($conn,$query);
if (mysqli_num_rows($result)>0){
$row=$result->fetch_assoc();
$username=$row["username"];
$_SESSION["username"]=$username;
 }
else{
  $username=$email;
  $_SESSION["username"]=$username;
  $query="select email from studentinfo where username=\"$username\";";
  $result=mysqli_query($conn,$query);
   $row=$result->fetch_assoc();
   $email=$row["email"];
   $_SESSION["email"]=$email;
 }

// Check if the cookie exists
if (isset($_COOKIE[$cookieName])) {
    // Decode the cookie data
    $cookieData = json_decode($_COOKIE[$cookieName], true);
    $lastLoginDate = new DateTime($cookieData['last_login']);
    $streakCount = $cookieData['streak'];

    // Calculate the difference in days
    $dateDiff = $currentDate->diff($lastLoginDate)->days;

    if ($dateDiff == 1) {
        // Increment streak if logged in consecutively
        $streakCount++;
    } else if ($dateDiff > 1) {
        // Reset streak if more than 1 day has passed
        $streakCount = 1;
    }
} else {
    // First login, set streak to 1
    $streakCount = 1;
}

// Update cookie data
$cookieData = [
    'streak' => $streakCount,
    'last_login' => $currentDate->format('Y-m-d')
];

// Save the updated cookie (valid for 30 days)
setcookie($cookieName, json_encode($cookieData), time() + (86400 * 30), '/');

// // Display streak to the user
// echo "Your current login streak is: " . $streakCount;
?>
<script>
  const streak=<?php echo json_encode($streakCount); ?>;

  var p=document.getElementById("streak");
  p.innerHTML=streak+" day 🔥 streak";

  const username=<?php echo json_encode($username);?>;
  var uname=document.getElementById('uname');
  uname.innerHTML="Welcome "+username;
</script>
</body>
</html>