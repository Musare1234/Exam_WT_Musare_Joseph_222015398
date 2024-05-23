<?php
include('db_connection.php');

// Check if profile_id is set
if (isset($_REQUEST['profile_id'])) {
  $profile_id = $_REQUEST['profile_id'];

  // Prepare statement with parameterized query to prevent SQL injection (security improvement)
  $stmt = $connection->prepare("SELECT * FROM user_profile WHERE profile_id=?");
  $stmt->bind_param("i", $profile_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profile_id = $row['profile_id'];
    $user_id = $row['user_id'];
    $name = $row['name'];
    $gender = $row['gender'];
    $date_of_birth = $row['date_of_birth'];
    $address = $row['address'];
    $profile_picture = $row['profile_picture'];
  } else {
    echo "Profile not found.";
  }
  $stmt->close(); // Close the statement after use
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User Profile</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update user profile form -->
        <h2><u>Update User Profile</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            <br><br>

            <label for="name">Name:</label>
            <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
            <br><br>

            <label for="gender">Gender:</label>
            <input type="text" name="gender" value="<?php echo isset($gender) ? $gender : ''; ?>">
            <br><br>

            <label for="date_of_birth">Date of Birth:</label>
            <input type="text" name="date_of_birth" value="<?php echo isset($date_of_birth) ? $date_of_birth : ''; ?>">
            <br><br>

            <label for="address">Address:</label>
            <input type="text" name="address" value="<?php echo isset($address) ? $address : ''; ?>">
            <br><br>

            <label for="profile_picture">Profile Picture URL:</label>
            <input type="text" name="profile_picture" value="<?php echo isset($profile_picture) ? $profile_picture : ''; ?>">
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
  $name = $_POST['name'];
  $gender = $_POST['gender'];
  $date_of_birth = $_POST['date_of_birth'];
  $address = $_POST['address'];
  $profile_picture = $_POST['profile_picture'];

  // Update the user profile in the database (prepared statement again for security)
  $stmt = $connection->prepare("UPDATE user_profile SET user_id=?, name=?, gender=?, date_of_birth=?, address=?, profile_picture=? WHERE profile_id=?");
  $stmt->bind_param("isssssi", $user_id, $name, $gender, $date_of_birth, $address, $profile_picture, $profile_id);
  $stmt->execute();

  // Redirect to appropriate page after update
  header('Location: user_profiles.php');
  exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
