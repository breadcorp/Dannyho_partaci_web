<?php
include('internal/server.php'); // Include your database connection

// Check if 'id' is set in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid Convoy ID.');
}

$convoy_id = intval($_GET['id']);

// Fetch convoy details based on the provided ID
$query = "SELECT * FROM convoys WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $convoy_id);
$stmt->execute();
$result = $stmt->get_result();
$convoy = $result->fetch_assoc();

if (!$convoy) {
    die('Convoy not found.');
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Convoy Details</title>
    <style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%; /* Ensure body and html take up the full height */
        overflow-x: hidden; /* Prevent horizontal scrollbars */
        background-color: #222; /* Ensure consistent background */
        color: #f9f9f9;
    }

    .navbar {
            background-color: #333; /* Dark navbar */
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: left;
        }
        
    .navbar a {
            color: #EEB400; /* Gold links */
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
    }

    .navbar a:hover {
            color: #ffffff; /* Hover effect */
    }


    .main-content {
        padding: 20px; /* Add padding for the main content */
        margin-top: 20px; /* Add margin for separation from the navbar */
    }

    .convoy-details {
        max-width: 800px;
        margin: 40px auto; /* Add margin from top */
        background: #333;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
    }

    .convoy-details h1 {
        margin: 0 0 20px;
        font-size: 26px;
        color: #EEB400;
        text-align: center;
    }

    .convoy-details p {
        margin: 10px 0;
        font-size: 16px;
        line-height: 1.5;
        color: #ddd;
    }

    .convoy-details a {
        color: #EEB400;
        text-decoration: none;
        font-weight: bold;
    }

    .convoy-details a:hover {
        text-decoration: underline;
    }

    button, .back-btn {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #333; /* Gold color */
        color: #222; /* Black text */
        text-decoration: none;
        border: none;
        border-radius: 6px; /* Rounded corners */
        font-weight: bold;
        font-size: 14px;
        text-align: center;
        transition: background-color 0.3s, transform 0.2s;
        cursor: pointer;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    }

button:hover, .back-btn:hover {
    background-color: #DDA300; /* Darker gold on hover */
    color: #000; /* Keep text black */
    transform: translateY(-3px); /* Lift the button slightly on hover */
}

button:active, .back-btn:active {
    background-color: #C99100; /* Even darker gold when clicked */
    transform: translateY(0); /* Return to original position */
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); /* Adjust shadow on click */
    color: #000; /* Keep text black */
}



    </style>
</head>
<body>
    <div class="navbar">
    <a href="index.php">Home</a>
    <a href="team.php" class="nav-link">Team</a>
    <a href="partners.php" class="nav-link">Partners</a>
    <a href="convoy.php" class="nav-link">Next 3 convoys</a>
    <a href="slots_select.php" class="nav-link">Book your slot</a>
    <a href="dpconvoys.php" class="nav-link">Our convoys</a>
    <a href="../phplogin/index.php" class="nav-link">Login</a>
    </div>

    <div class="convoy-details">
        <h1><?php echo htmlspecialchars($convoy['name']); ?></h1>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($convoy['date']); ?></p>
        <p><strong>Start:</strong> <?php echo htmlspecialchars($convoy['start']); ?></p>
        <p><strong>End:</strong> <?php echo htmlspecialchars($convoy['end']); ?></p>
        <p><strong>Server:</strong> <?php echo htmlspecialchars($convoy['server']); ?></p>
        <p><strong>Length:</strong> <?php echo htmlspecialchars($convoy['length'] ?? 'N/A'); ?> km</p>
        <p><strong>DLC Required:</strong> <?php echo htmlspecialchars($convoy['dlc'] ?? 'None'); ?></p>
        <p><strong>Convoy URL:</strong> 
            <a href="<?php echo htmlspecialchars($convoy['url']); ?>" target="_blank">
                <?php echo htmlspecialchars($convoy['url']); ?>
            </a>
        </p>
        <p><strong>Slot URL:</strong> 
            <a href="<?php echo htmlspecialchars($convoy['slot_url']); ?>" target="_blank">
                <?php echo htmlspecialchars($convoy['slot_url']); ?>
            </a>
        </p>
        <a href="convoy.php" class="back-btn">Back to Convoys</a>
    </div>
</body>
</html>
