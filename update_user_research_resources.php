<?php
include('db_connection.php');

// Check if resource_id is set
if (isset($_REQUEST['resource_id'])) {
  $resource_id = $_REQUEST['resource_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM user_research_resources WHERE resource_id=?");
  $stmt->bind_param("i", $resource_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $resource_id = $row['resource_id'];
    $title = $row['title'];
    $description = $row['description'];
    $file_url = $row['file_url'];
    $workshop_id = $row['workshop_id'];
  } else {
    echo "Resource not found.";
  }
  $stmt->close(); // Close the statement after use
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Research Resource</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update research resource form -->
        <h2><u>Update Research Resource</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
            <br><br>

            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo isset($description) ? $description : ''; ?>">
            <br><br>

            <label for="file_url">File URL:</label>
            <input type="text" name="file_url" value="<?php echo isset($file_url) ? $file_url : ''; ?>">
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
  $title = $_POST['title'];
  $description = $_POST['description'];
  $file_url = $_POST['file_url'];
  $workshop_id = $_POST['workshop_id'];

  // Update the research resource in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE user_research_resources SET title=?, description=?, file_url=?, workshop_id=? WHERE resource_id=?");
  $stmt->bind_param("sssii", $title, $description, $file_url, $workshop_id, $resource_id);
  $stmt->execute();

  // Redirect to appropriate page after update
  header('Location: user_research_resources.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
