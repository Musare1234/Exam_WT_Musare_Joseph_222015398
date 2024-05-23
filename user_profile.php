<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="styles.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>user_profile Page</title>
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
    <h1><u>user_profile Form</u></h1>

<form method="post" onsubmit="return confirmInsert();">

    <label for="profile_id">Profile_id:</label>
    <input type="number" id="book_id" name="book_id" required><br><br>

    <label for="user_id">Workshop_id:</label>
    <input type="number" id="ride_id" name="ride_id" required><br><br>

    <label for="name">Name:</label>
    <input type="text" id="passenger_id" name="passenger_id" required><br><br>

    <label for="gend">Gender:</label>
        <select name="gend" id="gend">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>

    <label for="date_of_birth">Date_of_birth:</label>
    <input type="time" id="passengeid" name="passengeid" required><br><br>

    <label for="address">Address:</label>
    <input type="number" id="passengid" name="passengid" required><br><br>

    <label for="profile_picture">Profile_picture:</label>
    <input type="number" id="passengid" name="passengd" required><br><br>
        </select><br><br>
    </select><br><br>

    <input type="submit" name="add" value="Insert">
</form>

<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO user_profile(profile_id, user_id, name,gender,date_of_birth,address,profile_picture) VALUES (?, ?, ?,?,?,?,?)");
    
    $stmt->bind_param("isssss", $profile_id, $user_id, $name,$gender,$date_of_birth,$address,$profile_picture);
    // Set parameters and execute
    $profile_id = $_POST['book_id'];
    $user_id = $_POST['ride_id'];
    $name = $_POST['passenger_id'];
    $gender = $_POST['passengerid'];
    $date_of_birth = $_POST['passengeid'];
    $address = $_POST['passengid'];
    $profile_picture = $_POST['passengd'];
    
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
    <title>user_profile Details</title>
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
    <center><h2>user_profile Table</h2></center>
    <table border="3">
        <tr>
         
            <th>profile_id</th>
            <th>user_id</th>
            <th>name</th>
            <th>gender</th>
            <th>date_of_birth</th>
            <th>address</th>
            <th>profile_picture</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
<?php
include('db_connection.php');

// Prepare SQL query to retrieve all user_profile
$sql = "SELECT * FROM user_profile";
$result = $connection->query($sql);

// Check if there are any user_profile
if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $profile_id = $row['profile_id']; // Fetch the profile_id
        echo "<tr>
        
            <td>" . $row['profile_id'] . "</td>
            <td>" . $row['user_id'] . "</td>
            <td>" . $row['name'] . "</td>
            <td>" . $row['gender'] . "</td>
            <td>" . $row['date_of_birth'] . "</td>
            <td>" . $row['address'] . "</td>
            <td>" . $row['profile_picture'] . "</td>
            <td><a style='padding:4px' href='delete_sessions.php?profile_id=$profile_id'>Delete</a></td> 
            <td><a style='padding:4px' href='update_sessions.php?profile_id=$profile_id'>Update</a></td> 
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

