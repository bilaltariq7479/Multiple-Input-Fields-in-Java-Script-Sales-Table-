<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sirsajjad";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert data from the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernames = $_POST['username'];
    $emails = $_POST['email'];
    $am = $_POST['amount'];

    // Loop through each set of data
    foreach ($usernames as $key => $username) {
        $email = $emails[$key];
        $sql = "INSERT INTO sales (customer_id, product_id,total_amount) VALUES ('$username', '$email', '$am')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Close connection
// $conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Form</title>
</head>
<body>
    <!-- <h1 id="total_bill">Total Bill: 0</h1> -->
    <form method="post" action="">
        <div id="input_fields">
            <label>Total Bill:</label> <input type="text" id="total_bill_input" readonly>
            <div>
                <label>Customer_id</label>
                <input type="text" name="username[]" required>
                <label>Product</label>
                 <select name="email[]" id="" required>
                    <?php 
                    $q="SELECT * FROM products";
                    $r=$conn->query($q);
                    while ($fdata=mysqli_fetch_array($r)) {
                 ?>
                     <option value=""><?php  echo $fdata['pname']; ?></option>
                      <?php  } ?>
                 </select>
                <!-- <input type="text" name="email[]" required> -->
            
                <label>Total Amount:</label>
                <input type="text" name="amount[]" required>
                <button type="button" onclick="addFields()">Add</button>
            </div>
        </div>
        <br>
        <input type="submit" value="Submit">
    </form>
        <script>
        function addFields() {
            var container = document.getElementById("input_fields");
            var newDiv = document.createElement("div");

            // Use AJAX to fetch product options
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    newDiv.innerHTML = '<div><label>Customer id:</label> <input type="text" name="username[]" required> <label>Product:</label> <select name="product[]" required onchange="updatePrice(this)">' + xhr.responseText + '</select> <label>Price:</label> <input type="text" name="price[]" readonly> <label>Quantity:</label> <input type="number" name="quantity[]" min="1" required oninput="calculateTotal(this)"> <label>Total Amount:</label> <input type="text" name="total_amount[]" readonly> <button type="button" onclick="removeFields(this)">Remove</button></div>';
                    container.appendChild(newDiv);
                }
            };
            xhr.open("GET", "get_products.php", true);
            xhr.send();
        }

        function removeFields(button) {
            button.parentNode.parentNode.removeChild(button.parentNode);
            updateTotalBill();
        }

        function updatePrice(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var price = selectedOption.getAttribute('data-price');
            var priceInput = selectElement.parentElement.querySelector('input[name="price[]"]');
            var quantityInput = selectElement.parentElement.querySelector('input[name="quantity[]"]');
            var totalAmountInput = selectElement.parentElement.querySelector('input[name="total_amount[]"]');
            priceInput.value = price;
            // Update total amount if quantity is already filled
            if (quantityInput.value) {
                calculateTotal(quantityInput);
            }
        }

        function calculateTotal(quantityInput) {
            var quantity = quantityInput.value;
            var priceInput = quantityInput.parentElement.querySelector('input[name="price[]"]');
            var totalAmountInput = quantityInput.parentElement.querySelector('input[name="total_amount[]"]');
            var price = priceInput.value;
            if (quantity && price) {
                totalAmountInput.value = quantity * price;
            } else {
                totalAmountInput.value = 0;
            }
            updateTotalBill();
        }

        function updateTotalBill() {
            var totalBill = 0;
            var totalAmountInputs = document.querySelectorAll('input[name="total_amount[]"]');
            totalAmountInputs.forEach(function(input) {
                totalBill += parseFloat(input.value) || 0;
            });
            document.getElementById('total_bill_input').value = totalBill;
        }
    </script>



   <!--  <script>
        function addFields() {
            var container = document.getElementById("input_fields");
            var newDiv = document.createElement("div");
            newDiv.innerHTML = '<div><label>Customer id:</label> <input type="text" name="username[]" required> <label>Product:</label> <input type="text" name="email[]" required> <label>Total Amount:</label> <input type="text" name="amount[]" required> <button type="button" onclick="removeFields(this)">Remove</button></div>';
            container.appendChild(newDiv);
        }

        function removeFields(button) {
            button.parentNode.parentNode.removeChild(button.parentNode);
        }
    </script> -->
</body>
</html>
