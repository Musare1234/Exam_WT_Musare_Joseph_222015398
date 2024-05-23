<?php
include('db_connection.php');

// Check if workshop_id is set
if (isset($_REQUEST['workshop_id'])) {
    $workshop_id = $_REQUEST['workshop_id'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM workshops WHERE workshop_id=?");
    $stmt->bind_param("i", $workshop_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $workshop_id = $row['workshop_id'];
        $title = $row['title'];
        $description = $row['description'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $instructor_id = $row['instructor_id'];
    } else {
        echo "Workshop not found.";
    }
    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Workshop Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update workshop information form -->
        <h2><u>Update Workshop Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>">
            <br><br>

            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo isset($description) ? $description : ''; ?>">
            <br><br>

            <label for="start_date">Start Date:</label>
            <input type="text" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>">
            <br><br>

            <label for="end_date">End Date:</label>
            <input type="text" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>">
            <br><br>

            <label for="instructor_id">Instructor ID:</label>
            <input type="text" name="instructor_id" value="<?php echo isset($instructor_id) ? $instructor_id : ''; ?>">
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
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $instructor_id = $_POST['instructor_id'];

    // Update the workshop in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE workshops SET title=?, description=?, start_date=?, end_date=?, instructor_id=? WHERE workshop_id=?");
    $stmt->bind_param("ssssii", $title, $description, $start_date, $end_date, $instructor_id, $workshop_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: workshops.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
