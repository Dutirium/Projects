<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comparison Line Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

   <style>
    /* General Body Styling */
body {
    background-color: #121212;
    color: #ffffff;
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

/* Chart Container */
.chart-container {
    width: 80%; /* Increased width */
    height: 70%;
    margin: 40px auto;
    padding: 30px;
    background: #1e1e1e;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover Effect for Chart Container */
.chart-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
}

/* Chart Canvas */
canvas {
    display: block;
    margin: 0 auto;
    width: 100%;  /* Ensures the canvas fills the container */
    height: 0%; /* Fixed height to make the chart larger */
}

/* Page Title */
h1 {
    text-align: center;
    color: #ffffff;
    font-size: 32px;
    margin-bottom: 20px;
}

/* Tooltip Styling (Chart.js) */
.chartjs-tooltip {
    background: rgba(40, 40, 40, 0.9);
    border-radius: 5px;
    color: #ffffff;
    padding: 8px 12px;
    font-size: 14px;
}

/* Axis Labels and Grid Lines */
.chart-axis {
    color: #ffffff !important;
    font-size: 14px;
}

/* Legend Styling */
.chart-legend {
    font-size: 14px;
    color: #ffffff;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .chart-container {
        width: 90%;
        padding: 20px;
    }

    h1 {
        font-size: 28px;
    }
}

@media (max-width: 768px) {
    .chart-container {
        width: 95%;
        padding: 15px;
    }

    h1 {
        font-size: 24px;
    }

    canvas {
        height: 400px; /* Slightly smaller height on tablets */
    }
}

@media (max-width: 480px) {
    .chart-container {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
    }

    h1 {
        font-size: 20px;
    }

    canvas {
        height: 300px; /* Further reduce height on small phones */
    }
}

/* Scrollbar Styling */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #2c2c2c;
}

::-webkit-scrollbar-thumb {
    background: #555;
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: #888;
}

   </style>
</head>
<body 0="background-color: #121212; color: white;">

    <div 0="width: 70%; margin: auto; padding-top: 50px;" class="chart-container">
       <canvas id="comparisonChart"></canvas>
    </div>
    <div class="p" id="p"></div>
    

   
      <?php
      $counter=-1;
       session_start();
       $email = $_SESSION["email"];
       $conn=mysqli_connect("localhost","root","","smartpath");

       $query = "SELECT type FROM studentinfo WHERE email = ?";
       $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Statement preparation failed: " .var_dump($stmt));
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $table = $row['type'];
    
     
        $allowedTables = ['parta', 'partb']; 
        if (!in_array($table, $allowedTables)) {
            if ($table===NULL)
            {
                $counter=0;
            }
            else{
            die("Some error occured");}
        }
    } else {
        die("No result found in studentinfo.");
    }
    $stmt->close();
       
    //Initialising the variable to zero
    $sumphy =0;
    $sumenv =0;
    $summath2 =0;
    $sumpps = 0;
    $sumelectrical = 0;
    $sumchem = 0;
    $summaths1 = 0;
    $sumss = 0;
    $sumelectronics =0;
    $summechanical =0; 
    $rowCount = 0;

      if($table=='parta')
      {
      $sql = "SELECT phy, env, math2, pps, electrical FROM $table";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        // Traverse through each row and calculate the sums
        while ($row = $result->fetch_assoc()) {
            $sumphy += (float)$row['phy'];   
            $sumenv += (float)$row['env'];   
            $summath2 += (float)$row['math2'];
            $sumpps += (float)$row['pps'];   
            $sumelectrical += (float)$row['electrical'];  
            $rowCount++;  
        }
        $sumphy = $sumphy / $rowCount;
        $sumenv= $sumenv / $rowCount;
        $summath2 = $summath2 / $rowCount;
        $sumpps = $sumpps / $rowCount;
        $sumelectrical = $sumelectrical / $rowCount;
      }
    }
      else
      {
        $sql = "SELECT chem, maths1, ss, electronics, mechanical FROM $table";
      $result = $conn->query($sql);
      if ($result) {
        // Traverse through each row and calculate the sums
        while ($row = $result->fetch_assoc()) {
            $sumchem += (float)$row['chem'];   
            $summaths1 += (float)$row['maths1'];   
            $sumss += (float)$row['ss']; 
            $sumelectronics += (float)$row['electronics'];   
            $summechanical += (float)$row['mechanical'];     
            $rowCount++;
         }

        $sumchem = $sumchem / $rowCount;
        $summaths1= $summaths1 / $rowCount;
        $sumss = $sumss / $rowCount;
        $sumelectronics = $sumelectronics / $rowCount;
        $summechanical = $summechanical / $rowCount;
      }
    }
      
      ?>
    <!--To get the data of the particular student-->
    <?php
    
    // Database configuration
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'smartpath';
    
    // Create a connection
    $conn = new mysqli($host, $username, $password, $dbname);
    
    // Check connection
    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Validate email
    if (empty($email)) {
        die("Invalid email.");
    }
    
    // Step 1: Get the `type` from `studentinfo`
    $query = "SELECT type FROM studentinfo WHERE email = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Statement preparation failed: " . var_dump($stmt));
    }
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $table = $row['type'];
    
        // Validate the table name to prevent SQL injection
        $allowedTables = ['parta', 'partb']; // Define allowed table names
        if (!in_array($table, $allowedTables)) {
            if($table===NULL)
            {
                $counter=0;
            }
            else{
            die("Some error occured");}
        }
    } else {
        die("No result found in studentinfo.");
    }
    $stmt->close();
    
    // Step 2: Fetch data from the dynamic table
    $query = "SELECT * FROM $table WHERE email = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    //Initialising the variables to zero
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $phy=0;
    $env=0;
    $math2 =0;
    $pps = 0;
    $electrical =0;
    $chem = 0;
    $math1 = 0;
    $electronics =0;
    $mechanical =0;
    $ss = 0;



    if ($row = $result->fetch_assoc()) {
        if ($table === 'parta') {
            $phy = $row['phy'];
            $env = $row['env'];
            $math2 = $row['math2'];
            $pps = $row['pps'];
            $electrical = $row['electrical'];
    
            // Output the results for `parta`
           
        } else {
            $chem = $row['chem'];
            $math1 = $row['maths1'];
            $electronics = $row['electronics'];
            $mechanical = $row['mechanical'];
            $ss = $row['ss'];
    
            
            
        }
    } else {
        echo "No record found in $table for the provided email.";
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
    ?>
    

    <script>
        const counter=<?php echo json_encode($counter)?>;
        if (counter==0)
    {
        var p= document.getElementById("p");
        p.innerHTML="First create your database!!";
    }
    else{

    // Get PHP variables into JavaScript
    const type = <?php echo json_encode($table); ?>;

    // Declare data variables
    let marksSet1 = [];
    let marksSet2 = [];

    if (type === 'partb') {
        const chem = <?php echo json_encode($chem); ?>;
        const math1 = <?php echo json_encode($math1); ?>;
        const electronics = <?php echo json_encode($electronics); ?>;
        const mechanical = <?php echo json_encode($mechanical); ?>;
        const ss = <?php echo json_encode($ss); ?>;

        //fetching average values
        const avgchem = <?php echo json_encode($sumchem); ?>;
        const avgmaths1 = <?php echo json_encode($summaths1); ?>;
        const avgelectronics = <?php echo json_encode($sumelectronics); ?>;
        const avgmechanical = <?php echo json_encode($summechanical); ?>;
        const avgss = <?php echo json_encode($sumss); ?>;
         // Debug output
        marksSet1 = [chem, math1, electronics, mechanical, ss];
        marksSet2 = [avgchem,avgmaths1, avgelectronics, avgmechanical, avgss ]; // average data for comparison

        var subjects = ['Chemstry','Maths-1','Electronics','Mechanical','Soft Skills'];

    } else {
       
        const phy = <?php echo json_encode($phy); ?>;
        const env = <?php echo json_encode($env); ?>;
        const math2 = <?php echo json_encode($math2); ?>;
        const pps = <?php echo json_encode($pps); ?>;
        const electrical = <?php echo json_encode($electrical); ?>;

        //fetching average values
        const avgphy = <?php echo json_encode($sumphy); ?>;
        const avgenv = <?php echo json_encode($sumenv); ?>;
        const avgmath2 = <?php echo json_encode($summath2); ?>;
        const avgpps = <?php echo json_encode($sumpps); ?>;
        const avgelectrical = <?php echo json_encode($sumelectrical); ?>;
        
        marksSet1 = [phy, env, math2, pps, electrical];
        marksSet2 = [avgphy,avgenv,avgmath2,avgpps,avgelectrical]; // average data for comparison

        var subjects = ['Physics','Environment','Maths-2','PPS','Elecrical'];
    }

    

    // Chart Configuration
    const config = {
        type: 'line',
        data: {
            labels: subjects, // X-axis labels
            datasets: [
                {
                    label: 'You',
                    data: marksSet1, // First dataset
                    borderColor: 'rgba(0, 123, 255, 1)',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderWidth: 2,
                    tension: 0.3 // Smooth curve
                },
                {
                    label: 'Average',
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
}
</script>


</body>
</html>
