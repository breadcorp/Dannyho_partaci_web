<?php
include('../phplogin/server.php');

// Načtení ID konvoje z URL
if (!isset($_GET['id'])) {
    die("ID konvoje nebylo zadáno.");
}
$convoy_id = intval($_GET['id']);

// Načtení detailů konvoje
$convoy_query = "SELECT name, date FROM convoys WHERE id = ?";
$stmt = $conn->prepare($convoy_query);
$stmt->bind_param("i", $convoy_id);
$stmt->execute();
$result = $stmt->get_result();
$convoy = $result->fetch_assoc();
$stmt->close();

if (!$convoy) {
    die("Konvoj nebyl nalezen.");
}

// Načtení všech areí pro daný konvoj
$areas_query = "SELECT id, area_number, vtc_name, max_slots, area_link FROM convoys_areas WHERE convoy_id = ?";
$stmt = $conn->prepare($areas_query);
$stmt->bind_param("i", $convoy_id);
$stmt->execute();
$areas_result = $stmt->get_result();
$stmt->close();

// Zpracování formuláře pro registraci VTC
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $area_id = intval($_POST['area_id']);
    $vtc_name = trim($_POST['vtc_name']);

    // Načtení aktuálních VTC a kontrola kapacity
    $check_query = "SELECT vtc_name, max_slots FROM convoys_areas WHERE id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("i", $area_id);
    $stmt->execute();
    $check_result = $stmt->get_result();
    $area_data = $check_result->fetch_assoc();
    $stmt->close();

    $registered_vtcs = explode(',', $area_data['vtc_name']);
    $registered_vtcs = array_filter(array_map('trim', $registered_vtcs)); // Odstranění prázdných položek

    if (count($registered_vtcs) >= $area_data['max_slots']) {
        $message = "This area is already full. Maximum number of VTCs: " . $area_data['max_slots'];
    } else {
        // Přidání nového VTC
        $registered_vtcs[] = $vtc_name;
        $updated_vtcs = implode(', ', $registered_vtcs);

        $update_query = "UPDATE convoys_areas SET vtc_name = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $updated_vtcs, $area_id);

        if ($stmt->execute()) {
            $message = "VTC '" . htmlspecialchars($vtc_name) . "' has been successfully registered.";
        } else {
            $message = "Registration error: " . $stmt->error;
        }
        $stmt->close();
    }
header("Refresh:1");
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VTC Registration: <?php echo htmlspecialchars($convoy['name']); ?></title>
    <style>
        body {
            background-color: #222;
            color: #f9f9f9;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        nav {
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

        nav a {
            color: #EEB400; /* Gold links */
            margin-right: 15px; /* Space between links */
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ffffff; /* Hover effect */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #333;
        }
        table, th, td {
            border: 1px solid #555;
        }
        th {
            background-color: #EEB400;
            color: #000;
            padding: 10px;
        }
        td {
            padding: 10px;
            text-align: center;
        }
        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #444;
            border: 1px solid #555;
            border-radius: 10px;
        }
        form label, form input, form select, form button {
            display: block;
            width: 100%;
            margin-bottom: 10px;
        }
        form button {
            background-color: #EEB400;
            color: #000;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #DDA300;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        .blinking-link {
            animation: blinkingColors 2s infinite;
            text-decoration: none;
            color: gold;
        }
        @keyframes blinkingColors {
            0% { color: red; }
            25% { color: yellow; }
            50% { color: green; }
            75% { color: blue; }
            100% { color: purple; }
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Home</a>
    <a href="convoy.php" class="nav-link">Next 3 convoys</a>
    <a href="team.php" class="nav-link">Team</a>
    <a href="partners.php" class="nav-link">Partners</a>
    <a href="slots_select.php" class="nav-link">Book your slot</a>
    <a href="dpconvoys.php" class="nav-link">Our convoys</a>
    <a href="../phplogin/index.php" class="nav-link">Login</a>
</nav>

<h1>VTC Registration: <?php echo htmlspecialchars($convoy['name']); ?></h1>
<p>Date: <?php echo htmlspecialchars($convoy['date']); ?></p>

<?php if (isset($message)): ?>
    <p class="<?php echo strpos($message, 'úspěšně') !== false ? 'success' : 'error'; ?>">
        <?php echo htmlspecialchars($message); ?>
    </p>
<?php endif; ?>

<!-- Formulář pro registraci do arey -->
<form method="POST"> 
    <label for="area_id">Choose area:</label>
    <select id="area_id" name="area_id" required>
        <?php
        $areas_result->data_seek(0); // Reset pointer
        while ($area = $areas_result->fetch_assoc()):
            $registered_vtcs = explode(',', $area['vtc_name']);
            $registered_vtcs = array_filter(array_map('trim', $registered_vtcs)); // Odstranění prázdných položek
            if (count($registered_vtcs) < $area['max_slots']): // Pouze volné arey
        ?>
                <option value="<?php echo htmlspecialchars($area['id']); ?>">
                    Area <?php echo htmlspecialchars($area['area_number']); ?> (Slots available: <?php echo $area['max_slots'] - count($registered_vtcs); ?>)
                </option>
        <?php
            endif;
        endwhile;
        ?>
    </select>

    <label for="vtc_name">VTC name:</label>
    <input type="text" id="vtc_name" name="vtc_name" placeholder="VTC name" required>

    <button type="submit">Register VTC</button>
</form>

<!-- Tabulka všech areí -->
<h2>Occupied Areas</h2>
<table>
    <thead>
        <tr>
            <th>Number of Area</th>
            <th>VTC name</th>
            <th>Max. capacity</th>
            <th>Link to slot</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $areas_result->data_seek(0); // Reset pointer
        while ($area = $areas_result->fetch_assoc()):
        ?>
            <tr>
                <td><?php echo htmlspecialchars($area['area_number']); ?></td>
                <td><?php echo htmlspecialchars($area['vtc_name'] ?? 'Volné'); ?></td>
                <td><?php echo htmlspecialchars($area['max_slots']); ?></td>
                <td>
                <?php if (!empty($area['area_link'])): ?>
                    <a href="<?php echo htmlspecialchars($area['area_link']); ?>" target="_blank" class="blinking-link">
                        <?php echo htmlspecialchars($area['area_link']); ?>
                    </a>
                <?php else: ?>
                    No link
                <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
