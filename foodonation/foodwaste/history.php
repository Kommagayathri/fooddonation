<?php
include("login.php");

// Check if the user is logged in
if(empty($_SESSION['name'])){
    header("location: signin.php");
    exit; // Stop executing further if not logged in
}

// Establish database connection
$connection = mysqli_connect("localhost", "root", "", "demo");

// Check connection
if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

// Fetch donation history from the database
$query = "SELECT * FROM food_donations WHERE email = '{$_SESSION['email']}'";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation History</title>
    <style>
        body {
            background-image: url("");
            /* background-color: #06C167; */
            font-family: 'Poppins', sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #06C167;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .no-history {
            text-align: center;
            color: #06C167;
            font-size: 20px;
        }

        .table-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <table>
            <caption class="table-title">Donation History</caption>
            <thead>
                <tr>
                    <th>Serial No.</th>
                    <th>Food Name</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any donations
                if(mysqli_num_rows($result) > 0){
                    $serial = 1;
                    // Display donation history
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>{$serial}</td>";
                        echo "<td>{$row['food']}</td>";
                        echo "<td>{$row['type']}</td>";
                        echo "<td>{$row['category']}</td>";
                        echo "<td>{$row['quantity']}</td>";
                        echo "</tr>";
                        $serial++;
                    }
                } else {
                    echo "<tr><td colspan='5' class='no-history'>No donation history found.</td></tr>";
                }

                // Close database connection
                mysqli_close($connection);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
