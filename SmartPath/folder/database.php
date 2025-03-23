<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABASE</title>

    <?php session_start(); ?>
    <STYLE>
/* General Styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #121212; /* Dark gray background */
    color: #e0e0e0; /* Light gray text */
}

/* Form Container */
form {
    width: 80%;
    margin: 20px auto;
    padding: 20px;
    background: #1e1e1e; /* Slightly lighter dark background for form */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.7);
    border-radius: 8px;
    color: #ffffff;
}

.partB{
  display: none;
  flex: 1;
    min-width: 280px;
}
/* Layout for Subject Sections */
.main {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

/* Section Styling */
.partA {
    flex: 1;
    min-width: 280px;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    background-color: #222; /* Dark table background */
    color: #e0e0e0; /* Light text for table */
}

th, td {
    text-align: left;
    padding: 10px;
    border: 1px solid #444; /* Dark border for table cells */
}

th {
    background-color: #333; /* Darker header background */
    font-weight: bold;
}

/* Input Styling */
input[type="number"] {
    width: 90%;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #555;
    border-radius: 4px;
    box-sizing: border-box;
    background-color: #1e1e1e; /* Match form background */
    color: #e0e0e0;
}

input[type="number"]:focus {
    outline: none;
    border-color: #4caf50; /* Green highlight on focus */
}

/* Button Styling */
button {
    display: block;
    width: 100px;
    margin: 0 auto;
    padding: 10px 15px;
    font-size: 16px;
    color: #ffffff;
    background-color: #4caf50; /* Green button */
    border: none;
    border-radius: 4px;
    cursor: pointer;
    text-transform: uppercase;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
}

button:hover {
    background-color: #3e8e41; /* Slightly darker green on hover */
}

/* Total Marks Display */
#p {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    margin-top: 20px;
    color: #e0e0e0;
}

/* Input Validation Error */
.error {
    border: 2px solid #f44336; /* Bright red for invalid inputs */
}

/* Responsive Design */
@media (max-width: 768px) {
    .main {
        flex-direction: column;
    }
    button {
        width: 100%;
    }
}

.switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 34px;
      background-color: red;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }
    
    input:checked + .slider {
      background-color: #2196F3;
    }

    input:checked + .slider:before {
      transform: translateX(26px);
      
    }

    #exists {
    width: 200px;
    height: 200px;
    background-color: #222; /* Inner background color */
   
    border-radius: 15px;
    box-shadow: 
        0 0 20px rgba(0, 255, 255, 0.8),
        0 0 40px rgba(0, 255, 255, 0.6),
        0 0 60px rgba(0, 255, 255, 0.4);
    transition: transform 0.3s ease-in-out;
    margin: auto;
    margin-top: 17%;
    font-family: fantasy;
    align-content: center;
    padding: 20px;
    font-size: 26px;
    width: fit-content;
    animation: flicker 2s infinite;
}

#exists:hover {
    transform: scale(1.1);
    animation: flickerUpdate 2s infinite;
}
@keyframes flickerUpdate{
  0%, 100% {
        box-shadow: 
            0 0 15px white,
            0 0 30px white,
            0 0 45px white;
    }
    50% {
        box-shadow: 
            0 0 25px white,
            0 0 50px white,
            0 0 75px white;
    }
    70% {
        box-shadow: 
            0 0 10px white,
            0 0 20px white,
            0 0 30px white;
    }

}


@keyframes flicker {
    0%, 100% {
        box-shadow: 
            0 0 15px rgba(0, 255, 255, 0.7),
            0 0 30px rgba(0, 255, 255, 0.5),
            0 0 45px rgba(0, 255, 255, 0.3);
    }
    50% {
        box-shadow: 
            0 0 25px rgba(0, 255, 255, 1),
            0 0 50px rgba(0, 255, 255, 0.8),
            0 0 75px rgba(0, 255, 255, 0.6);
    }
    70% {
        box-shadow: 
            0 0 10px rgba(0, 255, 255, 0.4),
            0 0 20px rgba(0, 255, 255, 0.3),
            0 0 30px rgba(0, 255, 255, 0.2);
    }
}

    

    </STYLE>

   
</head>
<body>
<div class="container" id="container">
<h1>Fill your marks</h1>


  <p >Switch subjects: </p>
<label class="switch">
    <input type="checkbox" id="toggleSwitch">
    <span class="slider"></span>
</label>


<form action="" method="POST">
 <div class="main">
    <div class="partB" id="partB">
    <TABLE>
     <tr> <th>SUBJECTS</th><th>MARKS</th></tr>  
     <TR><TD>MATHS-1:</TD><TD><input type="number" step="1" main="0" max="100" name="math1" id="math1"><br><br></TD></TR> 
     <TR><TD>CHEMISTRY:</TD><TD><input type="number" step="1" main="0" max="100" name="chem" id="chem"><br><br></TD></TR> 
     <TR><TD>MECHANICAL</TD><TD><input type="number" step="1" main="0" max="100" name="mechanical" id="mechanical"><br><br></TD></TR> 
     <TR><TD>ELECTRONICS:</TD><TD><input type="number" step="1" main="0" max="100" name="electronics" id="electronics"><br><br></TD></TR> 
     <TR><TD>SOFT-SKILLS:</TD><TD><input type="number" step="1" main="0" max="100" name="ss" id="ss"><br><br></TD></TR> 
     </TABLE>
    </div>

     <div class="partA" id="partA">
     <TABLE>
     <tr> <th>SUBJECTS</th><th>MARKS</th></tr>
     <TR><TD>MATHS-2:</TD><TD><input type="number" step="1" main="0" max="100" name="math2" id="math2"><br><br></TD></TR> 
     <TR><TD>PHYSICS:</TD><TD><input type="number" step="1" main="0" max="100" name="physics" id="phy"><br><br></TD></TR> 
     <TR><TD>ELECTRICAL</TD><TD><input type="number" step="1" main="0" max="100" name="electrical" id="electrical"><br><br></TD></TR> 
     <TR><TD>PPS:</TD><TD><input type="number" step="1" main="0" max="100" name="pps" id="pps"><br><br></TD></TR> 
     <TR><TD>ENVIRONMENT:  &nbsp;</TD><TD><input type="number" step="1" main="0" max="100" name="env" id="env"><br><br></TD></TR> 
     </TABLE> 
    </div>
</div>
<p id="state"></p>
<button name="submit" type="submit" id="submit">SUBMIT</button>
</form>
</div>
<div id="exists"></div> <!-- if database already exists -->



 <?php

$counter=0;
$email=$_SESSION["email"];
$username=$_SESSION["username"];

// checking for already existing database

$conn=mysqli_connect("localhost","root","","smartpath");
if(!$conn)
{
  die("THERE WAS SOME ERROR CONNECTING TO THE DARABASE".mysqli_error($conn));
}


$query="SELECT type FROM studentinfo WHERE email=\"$email\";";
$result=mysqli_query($conn,$query);
$row=$result->fetch_assoc();
$type=$row["type"];

if($email===null || $username===null)
{
  $counter=-2;// username or email is null
}
else if($type!=null)
{
 $counter=-1;// database alredy exists 
}
else 
{
  if(isset($_POST["submit"]))
  {
    // parta subjects
     $phy=$_POST["physics"];
     $env=$_POST["env"];
     $math2=$_POST["math2"];
     $pps=$_POST["pps"];
     $electrical=$_POST["electrical"];
     
     //partb subjects
     $chem=$_POST["chem"];
     $math1=$_POST["math1"];
     $ss=$_POST["ss"];
     $electronics=$_POST["electronics"];
     $mechanical=$_POST["mechanical"];
      

     
     
    
     if($math1==null)
     {
      //inserting values into parta
      $avg=($phy+$env+$math2+$pps+$electrical)/5.0;
      $query="INSERT INTO parta(phy,env,math2,pps,electrical,email) VALUES($phy,$env,$math2,$pps,$electrical,'$email');";
      $result=mysqli_query($conn,$query);

      // inserting values into leaderboard
      $query="INSERT INTO leaderboard(username,avg,type) VALUES('$username',$avg,'parta');";
      $result2=mysqli_query($conn,$query);

      // updating value in studentinfo
      $query="UPDATE studentinfo set type=\"parta\" where email='$email';";
      $result3=mysqli_query($conn,$query); 

      if($result && $result2){$counter=1;}
      else{echo var_dump($result).var_dump($result2);}
     }
     else 
     {
      $avg=($chem+$math1+$ss+$electronics+$mechanical)/5.0;

      // inserting the tuyupe of values in the type of table 
       $query= "INSERT INTO partb(chem,maths1,ss,electronics,mechanical,email) VALUES($chem,$math1,$ss,$electronics,$mechanical,'$email');";
       $result=mysqli_query($conn,$query);
       
      //inserting values in leaderboard 
       $query="INSERT INTO leaderboard(username,avg,type) VALUES('$username',$avg,'partb');";
       $result2=mysqli_query($conn,$query);

       //update type in studentinfo 
       $query="UPDATE studentinfo set type=\"partb\" where email='$email';";
       $result3=mysqli_query($conn,$query);


      if($result && $result2){$counter=1;}
      else{echo var_dump($result).var_dump($result2);}
     }
 


    

  }
}



?> 






<script>
        
        const partA=document.getElementById('partA');
        const partB=document.getElementById('partB');
        const button=document.getElementById('button');
        const state=document.getElementById("state");
        var counter=<?php echo json_encode("$counter");?>;
        var c=0;
        
        if(counter==-2)// for null values of email and usernme
        {
          stste.innerHTML="THERE WAS SOME ERROR WHILE FETCHING YOU USERNAME AND EMAIL";
        
        }
        
        if(counter==-1)// if th3e databse already exists.
        {
          exists=document.getElementById("exists");
          partA.style.display = 'none';
          partB.style.display = 'none';
          exists.style.display='block';
          document.getElementById("container").style.display='none';
          exists.innerHTML="YOUR DATABASE ALREADY EXISTS!";
        }
        
        if (counter==1)
        {
          exists=document.getElementById("exists");
          partA.style.display = 'none';
          partB.style.display = 'none';
          exists.style.display='block';
          document.getElementById("container").style.display='none';
          exists.innerHTML="DATA INSERTED SUCCESSFULLY";
        }

      toggleSwitch.addEventListener('change', () => {
      if (toggleSwitch.checked && c==0) {
       partB.style.display ='block';
        partA.style.display = 'none';
        c=1;
       
      } else if(c==1){
        c=0;
        partA.style.display = 'block';
        partB.style.display = 'none';
       }
    });

   
  </script>

</body>
</html>