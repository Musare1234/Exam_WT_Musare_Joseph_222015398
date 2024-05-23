<?php
include('db_connection.php');

// Check if payment_id is set
if (isset($_REQUEST['payment_id'])) {
  $payment_id = $_REQUEST['payment_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM payments WHERE payment_id=?");
  $stmt->bind_param("i", $payment_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $payment_id = $row['payment_id'];
    $user_id = $row['user_id'];
    $workshop_id = $row['workshop_id'];
    $amount = $row['amount'];
    $payment_date = $row['payment_date'];
    $payment_method = $row['payment_method'];
  } else {
    echo "Payment not found.";
  }
  $stmt->close(); // Close the statement after use
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Payment Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update payment information form -->
        <h2><u>Update Payment Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            <br><br>

            <label for="workshop_id">Workshop ID:</label>
            <input type="text" name="workshop_id" value="<?php echo isset($workshop_id) ? $workshop_id : ''; ?>">
            <br><br>

            <label for="amount">Amount:</label>
            <input type="text" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>">
            <br><br>

            <label for="payment_date">Payment Date:</label>
            <input type="text" name="payment_date" value="<?php echo isset($payment_date) ? $payment_date : ''; ?>">
            <br><br>

            <label for="payment_method">Payment Method:</label>
            <input type="text" name="payment_method" value="<?php echo isset($payment_method) ? $payment_method : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $user_id = $_POST['user_id'];
  $workshop_id = $_POST['workshop_id'];
  $amount = $_POST['amount'];
  $payment_date = $_POST['payment_date'];
  $payment_method = $_POST['payment_method'];

  // Update the payment in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE payments SET user_id=?, workshop_id=?, amount=?, payment_date=?, payment_method=? WHERE payment_id=?");
  $stmt->bind_param("iisisi", $user_id, $workshop_id, $amount, $payment_date, $payment_method, $payment_id);
  $stmt->execute();

  // Redirect to appropriate page after update
  header('Location: payments.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
