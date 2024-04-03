<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Bid</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media only screen and (max-width: 600px) {
            .container {
                width: 90%;
                margin: 20px auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Apply Bid</h2>
        <form action="fdata.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter Name" required><br>

            <label for="mobile_number">Mobile Number:</label>
            <input type="text" id="mobile_number" name="mobile_number" placeholder="Enter Mobile Number" required><br>

            <label for="bid_amount">Bid Amount:</label>
            <input type="number" id="bid_amount" name="bid_amount" placeholder="Enter Bid Amount" required><br>

            <input type="submit" value="Submit Bid">
        </form>
        <?php 
            // Display top 3 bidders from the database table
            $conn = new mysqli("localhost", "root", "", "skn_bid");

            $sql = "SELECT * FROM merchant ORDER BY bid_amount DESC LIMIT 3";
            $result = $conn->query($sql);
        
            if ($result === false) {
                // Handle SQL error
                die("Error executing query: " . $conn->error);
            }
        
            if ($result->num_rows > 0) {
                echo "<h2>Top 3 Bidders</h2>";
                echo "<table>";
                echo "<tr><th>Name</th><th>Mobile Number</th><th>Bid Amount</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['mobile_number']}</td>";
                    echo "<td>{$row['bid_amount']}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No bidders found in merchant table.";
            }
        
            // Close connection
            $conn->close();
        ?>
    </div>
</body>
</html>
