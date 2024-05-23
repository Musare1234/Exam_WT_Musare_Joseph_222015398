<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {

 include('db_connection.php');

    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'attendees' => "SELECT attendee_id FROM attendees WHERE attendee_id LIKE '%$searchTerm%'",
        'instructors' => "SELECT instructor_id FROM instructors WHERE instructor_id LIKE '%$searchTerm%'",
        'participants' => "SELECT participant_id FROM participants WHERE participant_id LIKE '%$searchTerm%'",
        'payments' => "SELECT  payment_method FROM payments WHERE payment_method LIKE '%$searchTerm%'",
        'session_attendance' => "SELECT attendance_id FROM session_attendance WHERE attendance_id LIKE '%$searchTerm%'",
         'user_profile' => "SELECT name FROM user_profile WHERE name LIKE '%$searchTerm%'",
        'sessions' => "SELECT session_id FROM sessions WHERE session_id LIKE '%$searchTerm%'",
        'user_research_resources' => "SELECT title FROM user_research_resources WHERE  title LIKE '%$searchTerm%'",
        'workshops' => "SELECT title FROM workshops WHERE title LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>


attendees(attendee_id, UserID, attendee_id)
instructors(instructor_id, UserID, bio,expertise)
participants(participant_id, user_id,workshop_id)
payments(payment_id, UserID, workshop_id,amount,payment_date,payment_method)
session_attendance(attendance_id, user_id, session_id,attendance_status)
sessions(session_id, workshop_id, session_date,start_time,end_time,session_topic)
user_profile(profile_id, user_id, name,gender,date_of_birth,address,profile_picture)
user_research_resources(resource_id, title, description,file_url,workshop_id)
workshops(workshop_id, title, description,start_date,end_date,instructor_id)