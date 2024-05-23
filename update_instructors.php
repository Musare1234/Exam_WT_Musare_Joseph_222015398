<?php
include('db_connection.php');

// Check if instructor_id is set
if (isset($_REQUEST['instructor_id'])) {
    $instructor_id = $_REQUEST['instructor_id'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM instructors WHERE instructor_id=?");
    $stmt->bind_param("i", $instructor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $instructor_id = $row['instructor_id'];
        $user_id = $row['user_id'];
        $bio = $row['bio'];
        $expertise = $row['expertise'];
    } else {
        echo "Instructor not found.";
    }
    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Instructor Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update instructor information form -->
        <h2><u>Update Instructor Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            <br><br>

            <label for="bio">Bio:</label>
            <input type="text" name="bio" value="<?php echo isset($bio) ? $bio : ''; ?>">
            <br><br>

            <label for="expertise">Expertise:</label>
            <input type="text" name="expertise" value="<?php echo isset($expertise) ? $expertise : ''; ?>">
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
    $bio = $_POST['bio'];
    $expertise = $_POST['expertise'];

    // Update the instructor in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE instructors SET user_id=?, bio=?, expertise=? WHERE instructor_id=?");
    $stmt->bind_param("sssi", $user_id, $bio, $expertise, $instructor_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: instructors.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
