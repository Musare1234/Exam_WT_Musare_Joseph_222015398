<?php
include('db_connection.php');

// Check if session_id is set
if (isset($_REQUEST['session_id'])) {
  $session_id = $_REQUEST['session_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM sessions WHERE session_id=?");
  $stmt->bind_param("i", $session_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $session_id = $row['session_id'];
    $workshop_id = $row['workshop_id'];
    $session_date = $row['session_date'];
    $start_time = $row['start_time'];
    $end_time = $row['end_time'];
    $session_topic = $row['session_topic'];
  } else {
    echo "Session not found.";
  }
  $stmt->close(); // Close the statement after use
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Session Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update session information form -->
        <h2><u>Update Session Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="workshop_id">Workshop ID:</label>
            <input type="text" name="workshop_id" value="<?php echo isset($workshop_id) ? $workshop_id : ''; ?>">
            <br><br>

            <label for="session_date">Session Date:</label>
            <input type="text" name="session_date" value="<?php echo isset($session_date) ? $session_date : ''; ?>">
            <br><br>

            <label for="start_time">Start Time:</label>
            <input type="text" name="start_time" value="<?php echo isset($start_time) ? $start_time : ''; ?>">
            <br><br>

            <label for="end_time">End Time:</label>
            <input type="text" name="end_time" value="<?php echo isset($end_time) ? $end_time : ''; ?>">
            <br><br>

            <label for="session_topic">Session Topic:</label>
            <input type="text" name="session_topic" value="<?php echo isset($session_topic) ? $session_topic : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
  // Retrieve updated values from form
  $workshop_id = $_POST['workshop_id'];
  $session_date = $_POST['session_date'];
  $start_time = $_POST['start_time'];
  $end_time = $_POST['end_time'];
  $session_topic = $_POST['session_topic'];

  // Update the session in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE sessions SET workshop_id=?, session_date=?, start_time=?, end_time=?, session_topic=? WHERE session_id=?");
  $stmt->bind_param("issssi", $workshop_id, $session_date, $start_time, $end_time, $session_topic, $session_id);
  $stmt->execute();

  // Redirect to appropriate page after update
  header('Location: sessions.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
