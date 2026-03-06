<?php
include('../phplogin/server.php');

// Base convoy query to filter only "Dannyho Parťáci"
$convoy_query = "SELECT id, name, date FROM convoys WHERE vtc_name = 'Dannyho Parťáci'";

// Handle search
$search_query = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
    $convoy_query .= " AND name LIKE ?";
    $stmt = $conn->prepare($convoy_query);
    $search_like = '%' . $search_query . '%';
    $stmt->bind_param("s", $search_like);
    $stmt->execute();
    $convoy_result = $stmt->get_result();
    $stmt->close();
} else {
    $convoy_result = $conn->query($convoy_query);
}

if (!$convoy_result) {
    die("Chyba při načítání konvojů: " . $conn->error);
}

// Fetch data for available slots
if (isset($_GET['id'])) {
    $convoy_id = intval($_GET['id']);
    $slots_query = "SELECT area_number, vtc_name, max_slots, area_link FROM convoys_areas WHERE convoy_id = ?";
    $stmt = $conn->prepare($slots_query);
    $stmt->bind_param("i", $convoy_id);
    $stmt->execute();
    $slots_result = $stmt->get_result();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slot Select</title>
    <link rel="stylesheet" href="../css/root.css">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #222;
            color: #f9f9f9;
        }
        nav {
            background-color: #333; /* Dark navbar */
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            justify-content: left;
        }
        
        nav a {
            color: #EEB400; /* Gold links */
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ffffff; /* Hover effect */
        }

        .main-container {
            padding: 20px;
        }
        .search-container {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        .search-container input[type="text"] {
            padding: 10px;
            border: 1px solid #555;
            border-radius: 5px;
            background-color: #333;
            color: #f9f9f9;
            margin-right: 10px;
        }
        .search-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #EEB400;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #DDA300;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .box {
            background-color: #444;
            border: 1px solid #555;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            width: calc(33.333% - 40px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .box h2 {
            font-size: 20px;
            margin: 10px 0;
            color: #EEB400;
        }
        .box p {
            font-size: 14px;
            color: #ddd;
        }
        .box a {
            color: #EEB400;
            text-decoration: none;
        }
        .box a:hover {
            text-decoration: underline;
        }
        .box:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        @media screen and (max-width: 768px) {
            .box {
                width: calc(50% - 20px);
            }
        }
        @media screen and (max-width: 480px) {
            .box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<nav>
    <a href="index.php" class="nav-link">Home</a>
    <a href="team.php" class="nav-link">Team</a>
    <a href="partners.php" class="nav-link">Partners</a>
    <a href="convoy.php" class="nav-link">Next 3 convoys</a>
    <a href="slots_select.php" class="nav-link">Book your slot</a>
    <a href="dpconvoys.php" class="nav-link">Our convoys</a>
    <a href="../phplogin/index.php" class="nav-link">Login</a>
  
</nav>

<div class="main-container">
    <h1>Convoy select</h1>

    <!-- Search Bar -->
    <div class="search-container">
        <form method="GET" action="slots.php">
            <input type="text" name="search" placeholder="Search by name" value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Convoys List -->
    <div class="container">
        <?php while ($convoy = $convoy_result->fetch_assoc()): ?>
            <div class="box">
                <h2><?php echo htmlspecialchars($convoy['name']); ?></h2>
                <p>Date: <?php echo htmlspecialchars($convoy['date']); ?></p>
                <a href="slots.php?id=<?php echo $convoy['id']; ?>">Select slot</a>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Slots List -->
    <?php if (isset($slots_result)): ?>
    <h2>Area list</h2>
    <div class="container">
        <?php while ($slot = $slots_result->fetch_assoc()): ?>
            <div class="box">
                <h2>Area <?php echo htmlspecialchars($slot['area_number']); ?></h2>
                <p>VTC name: <?php echo htmlspecialchars($slot['vtc_name'] ?? 'Volné'); ?></p>
                <p>Max. VTC: <?php echo htmlspecialchars($slot['max_slots']); ?></p>
                <a href="<?php echo htmlspecialchars($slot['area_link']); ?>" target="_blank">HERE IS PICTURE OF AREA</a>
            </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
