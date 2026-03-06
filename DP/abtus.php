<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1e1e1e; /* Dark background */
            color: #e0e0e0; /* Light text */
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #EEB400;
            margin: 40px 0 20px; /* Added extra top margin for better spacing */
        }

        /* Navbar Styles */
        .navbar {
            background-color: #333; /* Dark navbar */
            padding: 10px 20px;
            position: fixed; /* Make navbar fixed at the top */
            top: -0px; /* Slightly moved up */
            left: 0;
            width: 100%;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Align text to the left */
        }

        .navbar a {
            color: #EEB400; /* Gold links */
            margin-right: 15px; /* Space between links */
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: #ffffff; /* Hover effect */
        }

        .about-container {
            max-width: 1200px;
            margin: 80px auto 20px auto; /* Adjusted top margin for navbar */
            padding: 20px;
            background-color: #2e2e2e; /* Container background */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5); /* Subtle shadow */
            color: #e0e0e0;
        }

        .about-container h2 {
            color: #EEB400; /* Gold headings */
            margin-bottom: 10px;
        }

        .about-container p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .about-container p strong {
            color: #ffffff; /* White for bolded text */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .about-container {
                padding: 15px;
            }

            .about-container p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Home</a>
        <a href="convoy.php" class="nav-link">Next 3 convoys</a>
        <a href="abtus.php" class="nav-link">About us</a>
        <a href="team.php" class="nav-link">Team</a>
        <a href="slots_select.php" class="nav-link">Book your slot</a>
        <a href="dpconvoys.php" class="nav-link">Our convoys</a>
        <a href="../phplogin/index.php" class="nav-link">Login</a>
    </div>

    <h1>About Us</h1>
    <div class="about-container">
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
            <strong>Ondra and Jarda</strong> - They arrange the convoy invitations
        </p>
    </div>
</body>
</html>
