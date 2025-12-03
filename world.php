<?php
$host = '127.0.0.1';
$port = '3307'; // Update this if your MySQL port is different
$username = 'root'; // Your MySQL username
$password = ''; // Your MySQL password
$dbname = 'world';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the query parameters
    $country = isset($_GET['country']) ? $_GET['country'] : '';
    $context = isset($_GET['context']) ? $_GET['context'] : '';

    if ($context === 'cities') {
        // Fetch cities based on the country name
        $stmt = $conn->prepare("SELECT cities.name AS city_name, cities.district, cities.population 
                                 FROM cities
                                 JOIN countries ON cities.country_code = countries.code
                                 WHERE countries.name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display cities in an HTML table
        echo "<table border='1'>
                <tr>
                    <th>Name</th>
                    <th>District</th>
                    <th>Population</th>
                </tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['city_name']) . "</td>
                    <td>" . htmlspecialchars($row['district']) . "</td>
                    <td>" . htmlspecialchars($row['population']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        // Fetch country information
        $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state 
                                 FROM countries 
                                 WHERE name LIKE :country");
        $stmt->execute(['country' => "%$country%"]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display countries in an HTML table
        echo "<table border='1'>
                <tr>
                    <th>Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>";
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['name']) . "</td>
                    <td>" . htmlspecialchars($row['continent']) . "</td>
                    <td>" . htmlspecialchars($row['independence_year'] ?? 'N/A') . "</td>
                    <td>" . htmlspecialchars($row['head_of_state'] ?? 'N/A') . "</td>
                  </tr>";
        }
        echo "</table>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
