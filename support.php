<?php
session_start();

$chatFile = "C:\\Users\\Sergiu\\Desktop\\Master\\chat.txt"; // Use double backslashes in PHP

// Function to send user message and get bot response
function getBotResponse($message) {
    global $chatFile;

    // Write user message to file
    file_put_contents($chatFile, "USER: " . trim($message));

    // Wait for response from Python
    $startTime = time();
    while (true) {
        $response = file_get_contents($chatFile);

        // If response is from the bot, return it
        if (strpos($response, "BOT:") !== false) {
            return trim(str_replace("BOT:", "", $response));
        }

        // Timeout after 5 seconds
        if (time() - $startTime > 5) {
            return "Error: No response from the bot.";
        }

        usleep(500000); // Wait 0.5 seconds before checking again
    }
}

// Initialize chat history session (keep messages after submission)
if (!isset($_SESSION["chat_history"]) || empty($_SESSION["chat_history"])) {
    $_SESSION["chat_history"] = [
        ["bot" => "Hello! I am your support bot. I can answer the following questions:
        1️⃣ How to order a product?
        2️⃣ How to return a product?
        3️⃣ How to contact us?
        4️⃣ How to check the stock of our products?
        Type one of these questions or the question number to get a response."]
    ];
}

// Handle user input
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["message"])) {
    $message = trim($_POST["message"]);
    if (!empty($message)) {
        $responseMessage = getBotResponse($message);
        $_SESSION["chat_history"][] = ["user" => $message, "bot" => $responseMessage];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture Store Customer Support Chat</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Navigation Bar */
        nav {
            background-color: #ffffff;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            position: relative;
        }

        nav a {
            color: #343a40;
            text-decoration: none;
            font-size: 1.2rem;
            margin: 0 15px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
            position: relative;
        }

        nav a:hover {
            background-color: #f0f0f0;
        }

        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* Header */
        h1 {
            background-color: #343a40;
            color: white;
            padding: 20px;
            margin: 0;
            font-size: 2rem;
        }

        /* Chat Container */
        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        /* Chat Box */
        .chat-box {
            height: 300px;
            overflow-y: auto;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background: #ffffff;
            margin-bottom: 10px;
        }

        .chat-box p {
            padding: 8px;
            border-radius: 5px;
            max-width: 80%;
            word-wrap: break-word;
        }

        /* User Messages */
        .user-message {
            background-color: #28a745;
            color: white;
            text-align: right;
            margin-left: auto;
        }

        /* Bot Messages */
        .bot-message {
            background-color: #f0f0f0;
            color: black;
            text-align: left;
            margin-right: auto;
        }

        /* Form Styling */
        form {
            display: flex;
            justify-content: space-between;
        }

        input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
            margin-left: 10px;
        }

        button:hover {
            background-color: #218838;
        }

        /* Footer Styling */
        footer {
            text-align: center;
            background-color: #f8f9fa;
            color: gray;
            padding: 15px;
            font-size: 0.9rem;
            margin-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <a href="index.html">Home</a>
        <a href="cart.html">Cart</a>
        <a href="support.php">Support</a>
    </nav>

    <h1>Customer Support Chat</h1>

    <div class="chat-container">
        <div class="chat-box">
            <?php
            foreach ($_SESSION["chat_history"] as $chat) {
                if (isset($chat["user"])) {
                    echo "<p class='user-message'><strong>You:</strong> " . htmlspecialchars($chat["user"]) . "</p>";
                }
                echo "<p class='bot-message'><strong>Support:</strong> " . nl2br(htmlspecialchars($chat["bot"])) . "</p>";
            }
            ?>
        </div>
        <form method="POST" action="">
            <input type="text" name="message" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Furniture Store. All rights reserved.</p>
    </footer>

</body>
</html>
