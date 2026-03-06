<?php
include('internal/server.php'); // Include your database connection

// Fetch data for all members in the company
$query = "SELECT name, avatar, join_date, id FROM vtc_members";
$result = $conn->query($query);

if (!$result) {
    die("Chyba při načítání členů: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1e1e1e; /* Dark background */
            color: #e0e0e0; /* Light text */
            margin: 0;
            padding: 0;
        }
        
        h1 {
            text-align: center;
            color: #EEB400;
            margin: 20px 0;
        }

        /* Navbar */
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

        /* Team Container */
        .team-container {
            max-width: 1200px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 0 15px;
        }

        /* Team Member Cards */
        .team-member {
            background-color: #2e2e2e; /* Slightly lighter card background */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Subtle shadow */
            text-align: center;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.7); /* Enhanced shadow on hover */
        }

        /* Member Avatar */
        .team-member img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 15px;
            border: 2px solid #EEB400; /* Gold border */
            object-fit: cover;
        }

        /* Member Name */
        .team-member h3 {
            color: #EEB400; /* Gold text */
            font-size: 20px;
            margin: 10px 0 5px;
        }

        .team-member h3 a {
            color: inherit; /* Inherit color from h3 */
            text-decoration: none;
        }

        .team-member h3 a:hover {
            text-decoration: underline;
        }

        /* Member Info */
        .team-member p {
            font-size: 14px;
            color: #cccccc; /* Slightly dimmed text */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .team-container {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .team-member img {
                width: 100px;
                height: 100px;
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
    
    <h1>Team Members</h1>
    <div class="team-container">
        <?php while ($row = $result->fetch_assoc()): ?>
        <div class="team-member">
            <img src="<?php echo htmlspecialchars($row['avatar'] ?? 'default-avatar.png'); ?>" alt="Avatar">
            <h3><a href="https://truckersmp.com/user/<?php echo htmlspecialchars($row['id']); ?>" target="_blank"><?php echo htmlspecialchars($row['name']); ?></a></h3>
            <p>TMP Joined: <?php echo htmlspecialchars($row['join_date'] ?? 'N/A'); ?></p>
        </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
