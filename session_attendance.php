<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="styles.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>session_attendance Page</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: yellow;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */

      padding: 8px;
     
    }
  </style>

  <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
        
  </head>

  <header>

<body bgcolor="green">
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./image/logos.jpeg" width="90" height="60" alt="Logo">
  </li>
      <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a>
  </li>
   
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a>
  </li>

  <li style="display: inline; margin-right: 10px;"><a href="./Contact.html">Contact</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./attendees.php">Attendees</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./instructors.php">instructors</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./participants.php">Participants</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./payments.php">Payments</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./sessions.php">sessions</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./session_attendance.php">session_attendance</a>
  </li>  <li style="display: inline; margin-right: 10px;"><a href="./user_profile.php">user_profile</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./user_research_resources.php">user_research_resources</a>
  </li>
<li style="display: inline; margin-right: 10px;"><a href="./workshops.php">workshops</a>
  </li>
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>

</header>
<section>
    <h1><u>Session_attendance Form</u></h1>

<form method="post" onsubmit="return confirmInsert();">

    <label for="attendance_id">Attendance_id:</label>
    <input type="number" id="book_id" name="book_id" required><br><br>

    <label for="user_id">user_id:</label>
    <input type="number" id="ride_id" name="ride_id" required><br><br>

    <label for="session_id">Session_id:</label>
    <input type="date" id="passenger_id" name="passenger_id" required><br><br>

    <label for="attendance_status">Attendance_status:</label>
    <input type="time" id="passengerid" name="passengerid" required><br><br>

        </select><br><br>
    </select><br><br>

    <input type="submit" name="add" value="Insert">
</form>

<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO session_attendance(attendance_id, user_id, session_id,attendance_status) VALUES (?, ?, ?,?)");
    $stmt->bind_param("isss", $attendance_id, $user_id,$session_id,$attendance_status);
    // Set parameters and execute
    $attendance_id = $_POST['book_id'];
    $user_id = $_POST['ride_id'];
    $session_id = $_POST['passenger_id'];
    $attendance_status = $_POST['passengerid'];
   
    
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sessions Details</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>session_attendance Table</h2></center>
    <table border="3">
        <tr>
            <th>attendance_id</th>
            <th>user_id</th>
            <th>session_id</th>
            <th>attendance_status</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
<?php
include('db_connection.php');

// Prepare SQL query to retrieve all session_attendance
$sql = "SELECT * FROM session_attendance";
$result = $connection->query($sql);

// Check if there are any session_attendance
if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $attendance_id = $row['attendance_id']; // Fetch the attendance_id
        echo "<tr>
            <td>" . $row['attendance_id'] . "</td>
            <td>" . $row['user_id'] . "</td>
            <td>" . $row['session_id'] . "</td>
            <td>" . $row['attendance_status'] . "</td>
            <td><a style='padding:4px' href='delete_session_attendance.php?attendance_id=$attendance_id'>Delete</a></td> 
            <td><a style='padding:4px' href='update_session_attendance.php?attendance_id=$attendance_id'>Update</a></td> 
        </tr>";
    }

} else {
    echo "<tr><td colspan='7'>No data found</td></tr>";
}
// Close the database connection
$connection->close();
?>
      </table>

</body>

</section>
 
<footer>
  <center> 
   <b><h2>UR CBE BIT &copy, 2024 &reg, Designer by:Musare Joseph</h2></b>
  </center>
</footer>
  
</body>
</html>

