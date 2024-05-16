<!DOCTYPE html>
<html>
<head>
    <title>Dynamic Form</title>
</head>
<body>
    <form method="post" action="">
        <div id="input_fields">
            <div>
                <label>Amount:</label>
                <input type="text" name="amount[]" class="amount" required>
                <label>Quantity:</label>
                <input type="text" name="quantity[]" class="quantity" required>
                <label>Total Amount:</label>
                <input type="text" name="total_amount[]" class="total_amount" readonly>
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
            newDiv.innerHTML = '<div><label>Amount:</label> <input type="text" name="amount[]" class="amount" required> <label>Quantity:</label> <input type="text" name="quantity[]" class="quantity" required> <label>Total Amount:</label> <input type="text" name="total_amount[]" class="total_amount" readonly> <button type="button" onclick="removeFields(this)">Remove</button></div>';
            container.appendChild(newDiv);

            // Add event listeners to new fields
            var newAmountInput = newDiv.querySelector('.amount');
            var newQuantityInput = newDiv.querySelector('.quantity');
            var newTotalAmountInput = newDiv.querySelector('.total_amount');
            newAmountInput.addEventListener('input', calculateTotalAmount);
            newQuantityInput.addEventListener('input', calculateTotalAmount);
        }

        function removeFields(button) {
            button.parentNode.parentNode.removeChild(button.parentNode);
        }

        function calculateTotalAmount() {
            var amount = parseFloat(this.parentNode.querySelector('.amount').value);
            var quantity = parseFloat(this.parentNode.querySelector('.quantity').value);
            var totalAmount = isNaN(amount) || isNaN(quantity) ? 0 : amount * quantity;
            this.parentNode.querySelector('.total_amount').value = totalAmount.toFixed(2);
        }

        // Add event listeners to existing fields
        var existingAmountInputs = document.querySelectorAll('.amount');
        var existingQuantityInputs = document.querySelectorAll('.quantity');
        existingAmountInputs.forEach(function(input) {
            input.addEventListener('input', calculateTotalAmount);
        });
        existingQuantityInputs.forEach(function(input) {
            input.addEventListener('input', calculateTotalAmount);
        });
    </script>
</body>
</html>