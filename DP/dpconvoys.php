<?php
include('../phplogin/server.php'); // Include your database connection

// Fetch current convoys from the database, ordered by date in ascending order
$query = "SELECT * FROM convoys WHERE vtc_name = 'Dannyho Parťáci' ORDER BY date ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Convoys</title>
    <style>
        /* CSS Variables for Light and Dark Modes */
        :root {
            --background-color-light: #f4f4f4;
            --text-color-light: #333;
            --table-background-light: #fff;
            --table-header-light: #007bff;
            --table-header-text-light: #fff;

            --background-color-dark: #1e1e1e;
            --text-color-dark: #f4f4f4;
            --table-background-dark: #333;
            --table-header-dark: #555;
            --table-header-text-dark: #fff;
        }

        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: var(--background-color-light);
            color: var(--text-color-light);
            margin: 0;
            padding: 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: var(--background-color-dark);
            color: var(--text-color-dark);
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: var(--table-background-light);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: var(--table-header-light);
            color: var(--table-header-text-light);
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e9e9e9;
        }

        /* Dark Mode Table Styles */
        body.dark-mode table {
            background-color: var(--table-background-dark);
        }

        body.dark-mode th {
            background-color: var(--table-header-dark);
            color: var(--table-header-text-dark);
        }

        body.dark-mode tr:nth-child(even) {
            background-color: #444;
        }

        body.dark-mode tr:hover {
            background-color: #555;
        }

        /* Title Styling */
        h2 {
            text-align: center;
            color: #007bff;
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

        /* Responsive Table */
        @media (max-width: 768px) {
            table {
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

    <h2>Upcoming Convoys</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Start</th>
                <th>End</th>
                <th>DLC</th>
                <th>Length (KM)</th>
                <th>Slot URL</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['start']); ?></td>
                <td><?php echo htmlspecialchars($row['end']); ?></td>
                <td><?php echo htmlspecialchars($row['dlc']); ?></td>
                <td><?php echo htmlspecialchars($row['length'] ?: 'N/A'); ?></td>
                <td>
                    <?php if (!empty($row['slot_url'])): ?>
                        <a href="<?php echo htmlspecialchars($row['slot_url']); ?>" target="_blank">View Slot</a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <script>
        // Function to read a cookie
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Apply theme based on the 'mode' cookie
        function applyTheme() {
            const theme = getCookie("mode");
            if (theme === "dark") {
                document.body.classList.add("dark-mode");
            } else {
                document.body.classList.remove("dark-mode");
            }
        }

        // Apply theme on page load
        applyTheme();
    </script>
</body>
</html>
