<?php
// Database connection settings
$host = 'localhost'; // XAMPP default host
$dbname = 'only_gains'; // Database name
$username = 'root'; // XAMPP default username
$password = ''; // XAMPP default password (empty by default)

// Establishing connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Database connection successful!<br>";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $week = $_POST['week'];
    $physicalDamage = $_POST['physical_damage_kg'];
    $spoilage = $_POST['spoilage_kg'];
    $pestInfestation = $_POST['pest_infestation_kg'];
    $overRipening = $_POST['over_ripening_kg'];
    $solution = $_POST['solution'];

    // SQL query to insert data into the loss_report table
    $sql = "INSERT INTO loss_report (week, physical_damage_kg, spoilage_kg, pest_infestation_kg, over_ripening_kg, solution)
            VALUES (:week, :physical_damage_kg, :spoilage_kg, :pest_infestation_kg, :over_ripening_kg, :solution)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':week' => $week,
            ':physical_damage_kg' => $physicalDamage,
            ':spoilage_kg' => $spoilage,
            ':pest_infestation_kg' => $pestInfestation,
            ':over_ripening_kg' => $overRipening,
            ':solution' => $solution
        ]);

        echo "Record added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Loss Report</title>
</head>
<body>
    <h1>Add Loss Report</h1>
    <form method="POST" action="">
        <label for="week">Week:</label>
        <input type="text" id="week" name="week" required><br><br>

        <label for="physical_damage_kg">Physical Damage (kg):</label>
        <input type="number" step="0.01" id="physical_damage_kg" name="physical_damage_kg" required><br><br>

        <label for="spoilage_kg">Spoilage (kg):</label>
        <input type="number" step="0.01" id="spoilage_kg" name="spoilage_kg" required><br><br>

        <label for="pest_infestation_kg">Pest Infestation (kg):</label>
        <input type="number" step="0.01" id="pest_infestation_kg" name="pest_infestation_kg" required><br><br>

        <label for="over_ripening_kg">Over Ripening (kg):</label>
        <input type="number" step="0.01" id="over_ripening_kg" name="over_ripening_kg" required><br><br>

        <label for="solution">Solution:</label>
        <textarea id="solution" name="solution" required></textarea><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
