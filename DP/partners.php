<?php
include('../phplogin/server.php'); // Include your database connection

// Fetch all partners from the database
$query = "SELECT id, name, image_url, description FROM partners";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching partners: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partners</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            color: #EEB400;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
        }
        .navbar a {
            color: #EEB400;
            text-decoration: none;
            font-weight: bold;
            margin-right: 20px;
        }
        .navbar a:hover {
            text-decoration: underline;
        }
        .partners-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px auto;
            max-width: 1200px;
        }
        .partner-card {
            background-color: #333;
            border-radius: 8px;
            padding: 15px;
            width: 250px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .partner-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .partner-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #EEB400; /* Gold border for profile */
        }
        .partner-card h3 {
            font-size: 18px;
            margin: 10px 0;
            color: #EEB400;
        }
        .partner-card p {
            font-size: 14px;
            color: #aaa;
            margin-bottom: 15px;
        }
        .partner-card a {
            color: #EEB400;
            text-decoration: none;
            font-weight: bold;
        }
        .partner-card a:hover {
            text-decoration: underline;
        }
        h1 {
            text-align: center;
            color: #EEB400;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="index.php" class="nav-link">Home</a>
    <a href="team.php" class="nav-link">Team</a>
    <a href="partners.php" class="nav-link">Partners</a>
    <a href="convoy.php" class="nav-link">Next 3 convoys</a>
    <a href="slots_select.php" class="nav-link">Book your slot</a>
    <a href="dpconvoys.php" class="nav-link">Our convoys</a>
    <a href="../phplogin/index.php" class="nav-link">Login</a>
</div>

<h1>Our Partners</h1>

<div class="partners-container">
    <?php while ($partner = $result->fetch_assoc()): ?>
    <div class="partner-card">
        <img src="<?php echo htmlspecialchars($partner['image_url']); ?>" alt="<?php echo htmlspecialchars($partner['name']); ?>">
        <h3><?php echo htmlspecialchars($partner['name']); ?></h3>
        <p><a href="partner.php?id=<?php echo htmlspecialchars($partner['id']); ?>">Learn more</a></p>
    </div>
    <?php endwhile; ?>
</div>

</body>
</html>
