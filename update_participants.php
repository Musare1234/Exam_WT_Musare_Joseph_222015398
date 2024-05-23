<?php
include('db_connection.php');

// Check if participant_id is set
if (isset($_REQUEST['participant_id'])) {
  $participant_id = $_REQUEST['participant_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM participants WHERE participant_id=?");
  $stmt->bind_param("i", $participant_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $participant_id = $row['participant_id'];
    $user_id = $row['user_id'];
    $workshop_id = $row['workshop_id'];
  } else {
    echo "Participant not found.";
  }
  $stmt->close(); // Close the statement after use
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Participant Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update participant information form -->
        <h2><u>Update Participant Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            <br><br>

            <label for="workshop_id">Workshop ID:</label>
            <input type="text" name="workshop_id" value="<?php echo isset($workshop_id) ? $workshop_id : ''; ?>">
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

  // Update the participant in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE participants SET user_id=?, workshop_id=? WHERE participant_id=?");
  $stmt->bind_param("isi", $user_id, $workshop_id, $participant_id);
  $stmt->execute();

  // Redirect to appropriate page after update
  header('Location: participants.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
