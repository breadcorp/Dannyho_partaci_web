<?php
include('../phplogin/server.php'); // Include your database connection

// Fetch the next 3 upcoming convoys ordered by date
$query = "SELECT id, name, date, server, start, end FROM convoys WHERE date >= NOW() ORDER BY date ASC LIMIT 3";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching convoys: " . $conn->error);
}
?>


<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Convoys</title>
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #1e1e1e; /* Dark background */
            color: #e0e0e0; /* Light text */
            margin: 0;
            padding: 0;
        }

        /* Navbar */
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
            display: flex; /* Add flexbox */
            justify-content: flex-start; /* Align items to the left */
            align-items: center; /* Vertically center items */
        }

        .navbar a {
            color: #EEB400;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }


        .navbar a:hover {
            color: #ffffff; /* White hover effect */
        }

        /* Header */
        h1 {
            text-align: center;
            color: #EEB400; /* Gold */
            margin: 40px 0 20px;
        }

        /* Convoy Container */
        .convoy-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #2e2e2e; /* Dark container background */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Subtle shadow */
        }

        .convoy {
            margin-bottom: 20px;
            padding: 15px;
            background: #333; /* Slightly darker background for convoys */
            border: 1px solid #444; /* Border for separation */
            border-radius: 8px;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .convoy:hover {
            background-color: #444; /* Darker hover effect */
            transform: translateY(-5px); /* Subtle lift on hover */
        }

        .convoy h3 {
            margin: 0;
            font-size: 20px;
            color: #EEB400; /* Gold heading */
        }

        .convoy p {
            margin: 5px 0;
            font-size: 16px;
            color: #ccc; /* Light grey text */
        }

        .convoy a {
            color: #EEB400; /* Gold links */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .convoy a:hover {
            color: #ffffff; /* White hover effect */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .convoy-container {
                padding: 15px;
            }

            .convoy p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php" class="nav-link">Home</a>
        <a href="team.php" class="nav-link">Team</a>
        <a href="partners.php" class="nav-link">Partners</a>
        <a href="convoy.php" class="nav-link">Next 3 convoys</a>
        <a href="slots_select.php" class="nav-link">Book your slot</a>
        <a href="dpconvoys.php" class="nav-link">Our convoys</a>
        <a href="../phplogin/index.php" class="nav-link">Login</a>
    </div>

    <h1>Upcoming Convoys</h1>
    <div class="convoy-container">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="convoy">
            <h3><a href="convoy_info.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['name']); ?></a></h3>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></p>
            <p><strong>Server:</strong> <?php echo htmlspecialchars($row['server']); ?></p>
            <p><strong>Start:</strong> <?php echo htmlspecialchars($row['start']); ?></p>
            <p><strong>End:</strong> <?php echo htmlspecialchars($row['end']); ?></p>
        </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
