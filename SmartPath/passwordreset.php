<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        /* General Body Styling */
        body {
          background: linear-gradient(135deg, #0f0f10, #1a1a2e);
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Main Container Styling */
        .main {
            width: 400px;
            margin: 8% auto;
            background-color: #2b2b3d;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);
        }

        /* Heading */
        h1 {
            color: #ffffff;
            margin-bottom: 20px;
        }

        /* Input Styling */
        input {
            width: 100%;
            height: 40px;
            margin-bottom: 15px;
            border: none;
            border-bottom: 2px solid #555;
            background: transparent;
            color: #fff;
            font-size: 14px;
            outline: none;
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
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #388e3c;
        }

        /* Error/Success Messages */
        #paragraph {
            margin-top: 15px;
            color: #ff4d4d;
            font-size: 14px;
        }

        a {
            text-decoration: none;
            color: #4caf50;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="main">
        <form action="" method="POST">
            <h1>Reset Password</h1>
            <label>Enter your password:</label><br>
            <input type="password" name="password" required><br><br>
            <label>Confirm your password:</label><br>
            <input type="password" name="cpassword" required><br><br>
            <button type="submit" name="reset">Reset</button><br><br>
            <p id="paragraph"></p>
        </form>
    </div>

<?php
$counter = 0;

if (isset($_POST["reset"])) {
    session_start();
    if (!isset($_SESSION["email"])) {
        die("Session expired. Please start over.");
    }

    $email = $_SESSION["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];

    // Check if passwords match
    if ($password !== $cpassword) {
        $counter = 1; // Passwords do not match
    } 
    // Check password strength
    else if (strlen($password) < 8) {
        $counter = 4; // Weak password
    } 
    else {
        $conn = mysqli_connect("localhost", "root", "", "smartpath");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if new password matches old password
        $stmt = $conn->prepare("SELECT password FROM studentinfo WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($password, $hashed_password)) {
            $counter = 2; // New password cannot match old password
        } else {
            // Update with new password
            $new_hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE studentinfo SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $password, $email);

            if ($stmt->execute()) {
                $counter = 3; // Password changed successfully
            } else {
                die("Error updating password: " . mysqli_error($conn));
            }

            $stmt->close();
        }

        $conn->close();
    }
}
?>

<script>
    let c = <?php echo $counter; ?>;
    const p = document.getElementById('paragraph');

    if (c === 1) {
        p.innerHTML = "Passwords do not match.";
    } else if (c === 2) {
        p.innerHTML = "New password cannot be the same as the old password.";
    } else if (c === 3) {
        p.style.color = "#4caf50";
        p.innerHTML = "Password changed successfully. Go back to <a href='LogIn.php'>Log In</a>.";
    } else if (c === 4) {
        p.innerHTML = "Password must be at least 8 characters long.";
    }
</script>
<script>
        const prsnlroom = document.getElementById('prsnlroom');

        prsnlroom.addEventListener('pointerdown', (event) => {
            const wave = document.createElement('div');
            wave.classList.add('wave');

            // Calculate position
            const rect = prsnlroom.getBoundingClientRect();
            wave.style.left = `${event.clientX - rect.left}px`;
            wave.style.top = `${event.clientY - rect.top}px`;

            prsnlroom.appendChild(wave);

            // Remove wave after animation
            wave.addEventListener('animationend', () => {
                wave.remove();
            });
        });
    </script>
</body>
</html>
