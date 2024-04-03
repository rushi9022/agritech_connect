<?php
require('nav2.php');
if(isset($_SESSION['name']))
{

}
else{
    exit();
    header("Location: index.php");
}
?>


<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require('conn.php'); // Include your database connection script
        
        // Get the data from the form
        $farmerId = $_POST["farmer_id"];
        //$text = $_POST["text"];
//         if (isset($_POST["option"])) {
//             $option = $_POST["option"];
            

//     if ($option === "askQuery") {
//         $updateQuery = "UPDATE `problems` SET `que` = '$text' WHERE `id` = '$farmerId'";
        
//         // Use prepared statements to prevent SQL injection
//         if ($stmt = $conn->query($updateQuery)) {
//             echo $text."".$farmerId;
//             echo "query submitted successfully.";
            
//         }  } elseif ($option === "submitSolution") {
//             $updateQuery = "UPDATE `problems` SET `ans` = '$text' WHERE `id` = '$farmerId'";
            
//             // Use prepared statements to prevent SQL injection
//             if ($stmt = $conn->query($updateQuery)) {
//                 echo $text."".$farmerId;
//                 echo "Solution submitted successfully.";
                
//             }  }
            
//             // Display a success message based on the selected option
//             echo "Operation completed successfully.";
// } else {
//     echo "Please select an option."; // Handle the case where no option is selected.
// }
}
echo '<script>var farmerId = ' . json_encode($farmerId) . ';</script>';

?>







<!DOCTYPE html>
<html>
<head>
    <title>WhatsApp-like Chat</title>
    <link rel="stylesheet" type="text/css" href="viewchatcss.css">
    <style>
        /* Add your CSS styles here */
        body {
            font-family: Arial, sans-serif;
        }
        .chat-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .message {
            background-color: #DCF8C6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .user-message {
            background-color: #DCF8C6;
            text-align: right;
        }
        .contact-message {
            background-color: #E2E2E2;
        }
        .input-container {
            margin-top: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .send-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .send-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <br>
<div class="chat-container">
    <div id="chat-messages">
        <!-- Chat messages will be displayed here -->
    </div>
    <div class="input-containers">
        <input type="text" id="message" name="message" placeholder="Type your message" required>
        <div class="button-container">
            <button type="button" id="send-button" class="send-button">Send</button>
            <form method="post" action="view_query_expert.php">
                <button type="submit" class="send-button">Back</button>
            </form>
        </div>
    </div>
</div>


    
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to load chat messages
            function loadChat() {
                $.ajax({
                    type:"POST",
                    url: 'load_chat_exp.php',
                    data: {
                            farmerId: farmerId
                        }, // PHP script to retrieve chat messages
                    success: function(data) {
                        $('#chat-messages').html(data);
                        
                        // After loading messages, initiate another request
                        loadChat();
                    }
                });
            }
            
            // Load chat messages on page load
            loadChat();
            
            // Send chat message
            $('#send-button').click(function() {
                
                var message = $('#message').val();
                $.ajax({
                    url: 'send_exp_message.php', // PHP script to send chat message
                    type: 'POST',
                    data: { message: message,
                            id:farmerId },
                    success: function() {
                        $('#message').val(''); // Clear the input field
                    }
                });
            });
        });
    </script>
</body>
</html>
