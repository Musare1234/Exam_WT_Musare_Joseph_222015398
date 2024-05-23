<?php
include('db_connection.php');

// Check if attendance_id is set
if (isset($_REQUEST['attendance_id'])) {
    $attendance_id = $_REQUEST['attendance_id'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM session_attendance WHERE attendance_id=?");
    $stmt->bind_param("i", $attendance_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $attendance_id = $row['attendance_id'];
        $user_id = $row['user_id'];
        $session_id = $row['session_id'];
        $attendance_status = $row['attendance_status'];
    } else {
        echo "Attendance record not found.";
    }
    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Attendance Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update attendance information form -->
        <h2><u>Update Attendance Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            <br><br>

            <label for="session_id">Session ID:</label>
            <input type="text" name="session_id" value="<?php echo isset($session_id) ? $session_id : ''; ?>">
            <br><br>

            <label for="attendance_status">Attendance Status:</label>
            <input type="text" name="attendance_status" value="<?php echo isset($attendance_status) ? $attendance_status : ''; ?>">
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
    $session_id = $_POST['session_id'];
    $attendance_status = $_POST['attendance_status'];

    // Update the attendance record in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE session_attendance SET user_id=?, session_id=?, attendance_status=? WHERE attendance_id=?");
    $stmt->bind_param("sssi", $user_id, $session_id, $attendance_status, $attendance_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: session_attendance.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
