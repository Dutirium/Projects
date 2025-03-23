<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email</title>
    <style>
       /* General Body Styling */
body {
    overflow: hidden;
    background: linear-gradient(135deg, #0f0f10, #1a1a2e);
    color: #f5f5f5;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

/* Main Container Styling */
.main {
    width: 400px;
    height: auto;
    background: #2b2b3d;
    padding: 40px;
    font-size: 18px;
    border-radius: 15px;
    margin: 10% auto;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
    text-align: center;
}

/* Heading Styling */
h1 {
    color: #ffffff;
    font-size: 24px;
    margin-bottom: 20px;
}

/* Input Field Styling */
input {
    width: 100%;
    border: none;
    border-bottom: 2px solid #555;
    background: transparent;
    color: #ffffff;
    height: 35px;
    font-size: 16px;
    margin-bottom: 20px;
    outline: none;
    padding: 5px;
}

input:focus {
    border-bottom: 2px solid #4caf50;
}

/* Button Styling */
button {
    width: 100%;
    height: 45px;
    border-radius: 25px;
    border: none;
    background-color: #4caf50;
    color: #ffffff;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, transform 0.2s;
}

button:hover {
    background-color: #388e3c;
    transform: translateY(-2px);
}

/* Error/Info Message Styling */
#p {
    margin-top: 15px;
    color: #ff4d4d;
    font-size: 14px;
}

/* Links Styling */
a {
    text-decoration: none;
    color: #4caf50;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

/* Scapegoat Placeholder */
.scapegoat {
    height: 100px;
    width: 100%;
    background: transparent;
}

    </style>
</head>
<body>
    <div class="main">
        <h1>Verify Email</h1>
        <form action="" method="POST">
            <label for="email">Enter your email:</label><br><br>
            <input type="email" name="email" id="email" required> <br><br>
            <button type="submit" name="find">FIND ACCOUNT</button><br>
            <p id="p"></p>
        </form>
    </div>
    <div class="scapegoat"></div>

    <?php
    $counter = 0;

    if (isset($_POST["find"])) {
        $conn = mysqli_connect("localhost", "root", "", "smartpath");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $counter = 2; // Invalid email format
        } else {
            $stmt = $conn->prepare("SELECT * FROM studentinfo WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                session_start();
                $_SESSION["email"] = $email;
                header("Location: passwordreset.php");
                exit();
            } else {
                $counter = 1; // Email not found
            }
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <script>
        let c = <?php echo $counter; ?>;
        const container = document.getElementById('p');
        if (c === 1) {
            container.innerHTML = "The email does not exist.<br><a href='signUp.php' target='_blank'><button>Sign Up</button></a>";
        } else if (c === 2) {
            container.innerHTML = "Invalid email format.";
        }
    </script>
</body>
</html>
