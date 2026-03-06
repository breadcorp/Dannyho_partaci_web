<?php
include('../phplogin/server.php'); // Include database connection

// Check if 'id' is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Partner ID.");
}

$partner_id = intval($_GET['id']);

// Fetch partner details from the database
$query = "SELECT * FROM partners WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $partner_id);
$stmt->execute();
$result = $stmt->get_result();
$partner = $result->fetch_assoc();

if (!$partner) {
    die("Partner not found.");
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($partner['name']); ?> - Partner Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            color: #f9f9f9;
            margin: 0;
            padding: 20px;
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
        .partner-details {
            max-width: 800px;
            margin: 20px auto;
            background: #333;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .partner-details img {
            width: 100%;
            height: auto;
            max-height: 600px;
            object-fit: cover;
            border-radius: 8px;
        }
        .partner-details h1 {
            margin: 20px 0;
        }
        .partner-details p {
            font-size: 16px;
            line-height: 1.6;
            color: #ddd;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #EEB400;
            color: #000;
            text-decoration: none;
            border-radius: 4px;
        }
        .back-btn:hover {
            background-color: #DDA300;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="nav-link">Home</a>
        <a href="team.php" class="nav-link">Team</a>
        <a href="partners.php" class="nav-link">Partners</a>
        <a href="convoy.php" class="nav-link">Next 3 convoys</a>
        <a href="dpconvoys.php" class="nav-link">Our convoys</a>
        <a href="slots_select.php" class="nav-link">Book your slot</a>
        <a href="../phplogin/index.php" class="nav-link">Login</a>
    </div>

    <div class="partner-details">
        <img src="<?php echo htmlspecialchars($partner['image_url']); ?>" alt="<?php echo htmlspecialchars($partner['name']); ?>">
        <h1><?php echo htmlspecialchars($partner['name']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($partner['description'])); ?></p>
        <a href="partners.php" class="back-btn">Back to Partners</a>
    </div>
</body>
</html>
