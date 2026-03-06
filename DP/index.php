<?php
include('internal/server.php'); // Include your database connection

// Fetch the next convoy from the database
$query = "SELECT name, date, start, end, server, slot_url FROM convoys WHERE date >= NOW() ORDER BY date ASC LIMIT 1";
$result = $conn->query($query);
$next_convoy = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dannyho Parťáci</title>
    <style>
        /* General styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #1e1e1e;
            color: #f9f9f9;
            line-height: 1.6;
        }

        /* Navbar */
        nav {
            background-color: #333;
            color: #EEB400;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.5);
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #EEB400;
            padding: 8px 15px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav ul li a:hover {
            background-color: #EEB400;
            color: #333;
        }

        /* Header Section */
        .header {
            position: relative;
            height: 650px;
            background: url('photos/Navrh_1.png') no-repeat center center/cover;
        }

        /* Overlay */
        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .header-overlay h1 {
            color: #EEB400;
            font-size: 72px;
            margin: 0;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);
        }

        .header-overlay p {
            font-size: 28px;
            color: #f9f9f9;
            margin-top: 10px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.7);
        }


        /* Section styles */
        .section {
            padding: 50px 20px;
            text-align: center;
            border-bottom: 1px solid #444;
        }

        .section h2 {
            margin-bottom: 20px;
            color: #EEB400;
            font-size: 36px;
        }

        .section p {
            font-size: 18px;
            margin: 10px auto;
            max-width: 800px;
        }

        /* Convoy Details */
        .convoy-details {
            display: inline-block;
            text-align: left;
            background-color: #222;
            border-radius: 10px;
            padding: 20px;
            margin: 0 auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
            max-width: 600px;
        }

        .convoy-details p {
            margin: 10px 0;
        }

        .convoy-details a {
            color: #EEB400;
            text-decoration: none;
            font-weight: bold;
        }

        /* Footer styles */
        footer {
            background-color: #111;
            color: #ccc;
            padding: 40px 20px;
            text-align: center;
        }

        footer .footer-container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        footer .footer-container div {
            flex: 1 1 300px;
            margin: 10px;
        }

        footer .footer-container h4 {
            color: #EEB400;
            margin-bottom: 10px;
        }

        footer .footer-container ul {
            list-style: none;
            padding: 0;
        }

        footer .footer-container ul li {
            margin-bottom: 10px;
        }

        footer .footer-container ul li a {
            text-decoration: none;
            color: #ccc;
        }

        footer .footer-container ul li a:hover {
            color: #EEB400;
        }

        footer p {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav>
    <ul>
    <li><a href="index.php">Home</a></li>
    <li><a href="convoy.php" class="nav-link">Next 3 convoys</a></li>
    <li><a href="team.php" class="nav-link">Team</a></li>
    <li><a href="partners.php" class="nav-link">Partners</a></li>
    <li><a href="slots_select.php" class="nav-link">Book your slot</a></li>
    <li><a href="dpconvoys.php" class="nav-link">Our convoys</a></li>
    <li><a href="../phplogin/index.php" class="nav-link">Login</a></li>
    </ul>
</nav>
<script type="text/javascript" src="https://cookieconsent.popupsmart.com/src/js/popper.js"></script><script> window.start.init({Palette:"palette1",Mode:"floating left",Theme:"block",Location:"https://prewdis.dvestezar.cz/DP/terms.html",Time:"5",})</script>
<!-- Header -->
<div class="header">
    <div class="header-overlay">
        <h1>Dannyho Parťáci</h1>
        <p>Closer to reality</p>
    </div>
</div>

<!-- Next Convoy Section -->
<section id="next-convoy" class="section">
    <h2>Next Dannyho Parťáci Convoy</h2>
    <?php if ($next_convoy): ?>
        <div class="convoy-details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($next_convoy['name']); ?></p>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($next_convoy['date']); ?></p>
            <p><strong>Start:</strong> <?php echo htmlspecialchars($next_convoy['start']); ?></p>
            <p><strong>End:</strong> <?php echo htmlspecialchars($next_convoy['end']); ?></p>
            <p><strong>Server:</strong> <?php echo htmlspecialchars($next_convoy['server']); ?></p>
            <p><strong>Slot URL:</strong> 
                <a href="<?php echo htmlspecialchars($next_convoy['slot_url']); ?>" target="_blank">View Slot</a>
            </p>
        </div>
    <?php else: ?>
        <p>No upcoming convoys at the moment.</p>
    <?php endif; ?>
</section>

<!-- Who We Are Section -->
<section id="who-we-are" class="section">
    <h2>Who we are?</h2>
        <p><strong>We are Danny's Partners</strong>, a VTC formed after the majority split off from the old VTC we were in. 
        We were founded on <strong>6.5.2024</strong> as a group of people playing various games together. We focus on long and specialty transports. 
        We run our own, more realistic game setup where we don't exceed speeds higher than 90km/h. 
        Currently, we are purely Czech-Slovak-Polish VTC.</p>

        <h2>What is our goal?</h2>
        <p><strong>Nobody knows</strong>. We are not pushing the saw. Maybe one day we will be a VTC recognized by the whole ETS2 community.</p>

        <h2>What can we offer?</h2>
        <p>In our VTC we can offer you international convoys, first-class entertainment, various contests for DLC or games, 
        various giveaways, and most importantly, a professional team that takes care of this VTC.</p>

        <h2>Who all is behind DP?</h2>
        <p>
            <strong>Danny McKnight</strong> - The commander of the whole VTC, he always has the biggest say.<br>
            <strong>Danny Jerab</strong> - McKnight's right-hand man<br>
            <strong>Bread and Koolyc</strong> - Coders who take care of the website and discord bot<br>
            <strong>Ondra and Jarda</strong> - They arrange the convoy invitations<br>
            <strong>and Our external Staff</strong> Helping us on convoys, or resolving invitations<br>
            <strong>Drivers</strong> We LOVE you
        </p>
</section>

<!-- About Us Section -->
<section id="about-us" class="section">
    <h2>About Us</h2>
    <p>
        Our goal is to provide a realistic and engaging experience for our members. Whether you're looking to
        join organized convoys, participate in events, or simply enjoy a community of like-minded individuals,
        Dannyho Parťáci welcomes you.
    </p>
</section>

<!-- More Section -->
<section id="more" class="section">
    <h2>More</h2>
    <p>Additional content will be added soon.</p>
</section>

<!-- Footer -->
<footer>
    <div class="footer-container">
        <div>
            <h4>Information</h4>
            <ul>
                <li><a href="terms.html">Privacy Policy</a></li>
                <li><a href="terms.html">Terms and Conditions</a></li>
            </ul>
        </div>
        <div>
            <h4>Other Links</h4>
            <ul>
                <li><a href="https://truckersmp.com/vtc/71775">VTC Page</a></li>
                <li><a href="https://discord.gg/dannyhopartaci">Discord Invite</a></li>
                <li><a href="#">Become a Driver(Comming soon)</a></li>
            </ul>
        </div>
    </div>
    <p>&copy; 2024-2025 bread_corp/Dannyho Parťáci. All Rights Reserved.</p>
</footer>

</body>
</html>
