<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirsajjad";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from database
$q = "SELECT * FROM products";
$r = $conn->query($q);

// Generate options
$options = '';
if ($r->num_rows > 0) {
    while ($fdata = $r->fetch_assoc()) {
        $options .= '<option value="' . $fdata['pid'] . '" data-price="' . $fdata['price'] . '">' . $fdata['pname'] . '</option>';
    }
} else {
    $options .= '<option value="">No products available</option>';
}

// Close connection
$conn->close();

// Output options
echo $options;
?>
