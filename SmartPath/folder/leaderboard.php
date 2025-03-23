<?php
session_start();

// Handle backend logic: Fetch data from MySQL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetch'])) {
    // Database configuration
    $host = 'localhost';
    $dbname = 'smartpath';
    $user = 'root';
    $password = '';

    try {
        if (!isset($_SESSION["email"])) {
            throw new Exception("User is not logged in.");
        }

        $email = $_SESSION["email"];

        // Create a PDO connection
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch user type based on email
        $stmt = $pdo->prepare("SELECT type FROM studentinfo WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            throw new Exception("User type not found.");
        }

        $type = $user['type'];

        // Fetch leaderboard data
        $stmt = $pdo->prepare("SELECT username, avg FROM leaderboard WHERE type = :type ORDER BY avg DESC");
        $stmt->bindParam(':type', $type);
        $stmt->execute();

        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Send data as JSON
        header('Content-Type: application/json');
        echo json_encode($students);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
    <style>
        /* General Dark Theme Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            margin: 20px 0;
            font-size: 2rem;
            color: #ffffff;
        }

        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #1e1e1e;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #333;
        }

        th {
            background-color: #333;
            color: #ffffff;
            font-size: 1rem;
        }

        tr:nth-child(even) {
            background-color: #252525;
        }

        tr:nth-child(odd) {
            background-color: #1e1e1e;
        }

        tr:hover {
            background-color: #444;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            table {
                width: 90%;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <h1>🏆 Student Leaderboard</h1>
    <table id="leaderboard">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Name</th>
                <th>Average Score</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be dynamically populated here -->
        </tbody>
    </table>

    <script>
        async function fetchLeaderboard() {
            try {
                const response = await fetch('?fetch=1');
                const data = await response.json();

                if (data.error) {
                    console.error('Error:', data.error);
                    return;
                }

                const tableBody = document.querySelector('#leaderboard tbody');
                tableBody.innerHTML = '';

                data.forEach((student, index) => {
                    const row = `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${student.username}</td>
                            <td>${student.avg}</td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        // Fetch leaderboard on page load
        window.onload = fetchLeaderboard;
    </script>
</body>
</html>
