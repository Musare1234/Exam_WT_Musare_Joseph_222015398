<?php
include('db_connection.php');

// Check if attendee_id is set
if (isset($_REQUEST['attendee_id'])) {
  $attendee_id = $_REQUEST['attendee_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM attendees WHERE attendee_id=?");
  $stmt->bind_param("i", $attendee_id);
  $stmt->execute();
  $result = $stmt->get_result();
//attendee_id, UserID,  workshop_id
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $attendee_id = $row['attendee_id'];
    $user_id = $row['user_id'];
    $workshop_id = $row['workshop_id'];
  } else {
    echo "Attendee not found.";
  }
  $stmt->close(); // Close the statement after use
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Attendee Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update attendee information form -->
        <h2><u>Update Attendee Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            <br><br>

            <label for="workshop_id">workshop_id:</label>
            <input type="number" name="workshop_id" value="<?php echo isset($workshop_id) ? $workshop_id : ''; ?>">
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

  // Update the attendee in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE attendees SET user_id=?, workshop_id=? WHERE attendee_id=?");
  $stmt->bind_param("isi", $user_id, $workshop_id, $attendee_id);
  $stmt->execute();

  // Redirect to appropriate page after update
  header('Location: attendees.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
