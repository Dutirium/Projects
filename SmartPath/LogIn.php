<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styleLogin.css">
   
</head>
<body>
  <form action="" method="POST">
 <div class="main">
    <div class="left">
      <div class="leftcontent">
        <h1>Welcomne,User!</h1>
      Enter your email or user name: <br><br>
      <input type="text" id="email" name="email" required><br><br>
      Enter your password:<br><br>
      <input type="password" id="password" name="password" required><br><br>
     
      <button name="login" id="button">LogIn</button><br><br>
     
      <p id="forgot"> Don't have an account <a href="signUp.php">SignUp</a><br></p>
      
    </div>    
    </div>
  
</div>

<?php 
$counter=0;

if(isset($_POST['login'])) 
{
  session_start();
  $_SESSION['email']=$_POST["email"];
  
  //establishing connection 
   $conn= mysqli_connect("localhost","root","","smartpath"); 
   if($conn)
  {
    $email= mysqli_real_escape_string($conn, $_POST['email']);
    $password=$_POST["password"];

    $query="select * from studentinfo where email=\"$email\" and password=\"$password\"";
   
    $result = mysqli_query($conn,$query);

    $query="select * from studentinfo where username=\"$email\" and password=\"$password\"";

    $result2=mysqli_query($conn,$query);

    if(mysqli_num_rows($result)>0 || mysqli_num_rows($result2)>0)
    { 
    header("Location: personalspace.php"); exit;
    }
    
   
   else
   { 
    $counter=1;
    echo "<script>alert('The above password and email or username do not match');</script>";
   }
  }
  else{
  die("There was some error while connecting to the database".mysqli_connect_error());
  }

}

// ?>

<script>
  let c=<?php echo $counter;?>;
 

if (c==1)
{
  const paragraph= document.getElementById("forgot"); 
 
  paragraph.innerHTML="Don't have an account"+'<a href="signUp.php">SignUp</a><br><br>'+"Forgot Password?  "+'<a href="retrive.php">Change Password<a>';
}
</script>
</body>
</html>