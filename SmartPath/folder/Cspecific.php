<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
    /* General Body Styling */
body {
    background-color: #0d1117; /* Dark background */
    color: #c9d1d9; /* Light text for readability */
    font-family: 'Poppins', Arial, sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

/* Form Styling */
form {
    width: 80%;
    max-width: 400px;
    margin: 40px auto;
    padding: 25px;
    background-color: #161b22; /* Slightly lighter dark */
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    text-align: center;
}

form input, form button {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    background-color: #21262d;
    border: 1px solid #30363d;
    color: #c9d1d9;
    border-radius: 5px;
    font-size: 14px;
    box-sizing: border-box;
}

form input:focus {
    outline: none;
    border-color: #58a6ff;
    box-shadow: 0 0 5px rgba(88, 166, 255, 0.5);
}

form button {
    background-color: #238636;
    border: none;
    cursor: pointer;
    font-weight: bold;
    text-transform: uppercase;
}

form button:hover {
    background-color: #2ea043;
}

p#error {
    color: #ff7b72;
    font-size: 14px;
    margin-top: 10px;
}

/* Chart Container */
.main {
    width: 80%;
    margin: 40px auto;
    background-color: #161b22;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
    transition: transform 0.3s ease;
}

.main:hover {
    transform: scale(1.02);
}

.container {
    background-color: #1c2128;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

/* Chart Styling */
#comparisonChart {
    width: 100%;
    height: 400px;
    margin-top: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    form {
        width: 90%;
    }

    .main {
        width: 95%;
    }
}

/* Typography Enhancements */
h1, h2, h3 {
    text-align: center;
    color: #58a6ff;
    font-weight: bold;
    margin-bottom: 10px;
}
    </style>
</head>
<body style="background-color: #121212; color: white;">
    <form action="" method="POST">
    Type the username of the student: <br>
     <input type="text" id="username" name="username">
     <p id="error"></p>
     <button name="submit">SUBMIT</button>
     </form>

     <div style="width: 70%; margin: auto; padding-top: 50px;" class="main">
        <div class="container">
        <canvas id="comparisonChart"></canvas>
     </div>
     </div>

    <?php 
   session_start();
   $email = $_SESSION["email"] ?? null; // Prevent undefined index error
   
   $counter = 0;
   $type = null;
   $marks = [
       1 => ["phy" => 0, "env" => 0, "pps" => 0, "math2" => 0, "electrical" => 0],
       2 => ["phy" => 0, "env" => 0, "pps" => 0, "math2" => 0, "electrical" => 0]
   ];
   
   // Database Connection
   $conn = mysqli_connect("localhost", "root", "", "smartpath");
   if (!$conn) {
       die("Database connection failed: " . mysqli_connect_error());
   }
   
   // Check if submit button was clicked
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
       $username = $_POST["username"];
   
       // Fetch current user's type
       $stmt = $conn->prepare("SELECT type FROM studentinfo WHERE email = ?");
       $stmt->bind_param("s", $email);
       $stmt->execute();
       $result = $stmt->get_result();
       $row=$result->fetch_assoc();
       $type1 = $row["type"];
       // defining type2=null to prevent undefined error because php code executes all at once
       $type2=null;
   
       // Fetch to be compared user's type
       $stmt = $conn->prepare("SELECT type FROM studentinfo WHERE username = ?;");
       if ($stmt === false) {
           die("Prepare failed (Compared User Query): " . $conn->error);
       }
       $stmt->bind_param("s", $username);
       $stmt->execute();
       // $query="select type from studeninfo where email='$email';";
       $result = $stmt->get_result();
  
       if (mysqli_num_rows($result) > 0) {
           $row = $result->fetch_assoc();
           $type2 = $row["type"];
           
       } 
       
       if($type2==null)
        {
           $counter = 1; // User not found
        }
       // Compare types
      else if ($counter === 0 && $type1 === $type2) {
           if ($type1 === "parta") {
               $type = "parta";
               // fetching the email of the user trough input username
               $query= "select email from studentinfo where username='$username';";
               $result=mysqli_query($conn,$query);

               if($result)
               {
                $row=$result->fetch_assoc();
                $cemail=$row["email"];
               }

               $stmt = $conn->prepare("SELECT * FROM parta WHERE email = ?;");
               if ($stmt === false) {
                   die("Prepare failed (Part A - Compared User Query): " . $conn->error);
               }
               
               $stmt->bind_param("s", $cemail);
               $stmt->execute();
               $result1 = $stmt->get_result();
   
               $stmt = $conn->prepare("SELECT * FROM parta WHERE email = ?");
               if ($stmt === false) {
                   die("Prepare failed (Part A - Current User Query): " . $conn->error);
               }
               $stmt->bind_param("s", $email);
               $stmt->execute();
               $result2 = $stmt->get_result();
   
               if ($result1 && $result2) {
                   $compareuser = $result1->fetch_assoc();
                   $currentuser = $result2->fetch_assoc();
   
                   $marks = [
                       1 => ["phy" => $compareuser["phy"], "env" => $compareuser["env"], "pps" => $compareuser["pps"], "math2" => $compareuser["math2"], "electrical" => $compareuser["electrical"]],
                       2 => ["phy" => $currentuser["phy"], "env" => $currentuser["env"], "pps" => $currentuser["pps"], "math2" => $currentuser["math2"], "electrical" => $currentuser["electrical"]]
                   ];
               } else {$counter=3;}
           } else {
               $type = "partb";
               // getting email of the corressponding username to access partb
               $stmt=$conn->prepare("select email from studentinfo where username=?");
               $stmt->bind_param("s",$username);
               $stmt->execute();
               $result=$stmt->get_result();
               
               if(mysqli_num_rows($result)>0){
               $row=$result->fetch_assoc();
               $emailu=$row["email"];}

               $stmt = $conn->prepare("SELECT * FROM partb WHERE email = ?");
               if ($stmt === false) {
                   die("Prepare failed (Part B - Compared User Query): " . $conn->error);
               }
               $stmt->bind_param("s", $emailu);
               $stmt->execute();
               $result1 = $stmt->get_result();
   
               $stmt = $conn->prepare("SELECT * FROM partb WHERE email = ?");
               if ($stmt === false) {
                   die("Prepare failed (Part B - Current User Query): " . $conn->error);
               }
               $stmt->bind_param("s", $email);
               $stmt->execute();
               $result2 = $stmt->get_result();
   
               if ($result1 && $result2) {
                   $compareuser = $result1->fetch_assoc();
                   $currentuser = $result2->fetch_assoc();
   
                   $marks = [
                       1 => ["chem" => $compareuser["chem"], "maths1" => $compareuser["maths1"], "ss" => $compareuser["ss"], "electronics" => $compareuser["electronics"], "mechanical" => $compareuser["mechanical"]],
                       2 => ["chem" => $currentuser["chem"], "maths1" => $currentuser["maths1"], "ss" => $currentuser["ss"], "electronics" => $currentuser["electronics"], "mechanical" => $currentuser["mechanical"]]
                   ];
               }else {$counter=3;}
           }
       } else {
           $counter = 2; // Types do not match
       }
   }
   
   // Close connection
   $conn->close();
   
   
   ?>
   

     <script>
     const username= <?php echo json_encode($username);?>;
     var counter = <?php echo json_encode($counter); ?>;
     console.log("Counter:", counter);
 
     const paragraph = document.getElementById("error");
     if (counter === 1) {
         paragraph.innerHTML = "The user does not exist";
     } else if (counter === 2) {
         paragraph.innerHTML = "Cannot compare due to different subjects";
     }
     else if(counter===3)
     {
        paragraph.innerHTML="There was some error while fetching the data";
     }

 
     // Pass PHP data to JavaScript
     const type = <?php echo json_encode($type); ?>;
     const marks = <?php echo json_encode($marks); ?>;
 
     console.log("Type:", type);
     console.log("Marks:", marks);
 
     // initialising the markset variables to zero because again the code is execut4ed at once to prevent this initialising it to zero is essentaial
     marksSet1 = [0,0,0,0,0];
     marksSet2 = [0,0,0,0,0];

     if (type === "parta") {
        
           // user whoes marks are to be compared to
         const phy1 = marks[1]["phy"];
         const env1 = marks[1]["env"];
         const math21 = marks[1]["math2"];
         const pps1 = marks[1]["pps"];
         const electrical1 = marks[1]["electrical"];

          //original user
         const phy2 = marks[2]["phy"];
         const env2 = marks[2]["env"];
         const math22 = marks[2]["math2"];
         const pps2 = marks[2]["pps"];
         const electrical2 = marks[2]["electrical"];
         console.log("Physics:", phy1, "Environment:", env1);

         marksSet1 = [phy1, env1, math21, pps1, electrical1];
         marksSet2 = [phy2, env2, math22, pps2, electrical2];

         var subjects = ['Physics','Environment','Maths-2','PPS','Elecrical'];
     } else if (type === "partb") // doing the same for partb|| I am tired :(
     {
        const chem1 = marks[1]["chem"];
        const math11 =marks[1]["maths1"]; 
        const electronics1= marks[1]["electronics"];
        const mechanical1= marks[1]["mechanical"]; 
        const ss1 = marks[1]["ss"];

        const chem2 = marks[2]["chem"];
        const math12 =marks[2]["maths1"]; 
        const electronics2= marks[2]["electronics"];
        const mechanical2= marks[2]["mechanical"]; 
        const ss2 = marks[2]["ss"];

        marksSet1 = [chem1,math11,electronics1,mechanical1,ss1];
        marksSet2 = [chem2,math12,electronics2,mechanical2,ss2];

        var subjects = ['Chemstry','Maths-1','Electronics','Mechanical','Soft Skills'];
     }else {console.log("Enter the username");}
     
    // configuring the bar chart
     const config = {
        type: 'line',
        data: {
            labels: subjects, // X-axis labels
            datasets: [
                {
                    label: username,
                    data: marksSet1, // First dataset
                    borderColor: 'rgba(0, 123, 255, 1)',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderWidth: 2,
                    tension: 0.3 // Smooth curve
                },
                {
                    label: 'You',
                    data: marksSet2, // Second dataset
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 2,
                    tension: 0.3 // Smooth curve
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: 'white'
                    }
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: 'rgba(30, 30, 30, 0.9)',
                    titleColor: 'white',
                    bodyColor: 'white'
                    
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Subjects',
                        color: 'white'
                    },
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                },
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Marks',
                        color: 'white'
                      
                    },
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    }
                }
            }
        }
    };

    // Render the chart
    const ctx = document.getElementById('comparisonChart').getContext('2d');
    new Chart(ctx, config);
 
     </script>
     
</body>
</html>