<?php
require 'db.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Query to fetch the current status
    $query = "SELECT blasting FROM users"; // Select all rows from the users table

    $result = mysqli_query($connection, $query);
    if ($result) {
        // Toggle the status for each row
        while ($row = mysqli_fetch_assoc($result)) {
            $currentStatus = $row['blasting'];
            $newStatus = ($currentStatus == 'on') ? 'off' : 'on';
            
            // Query to update the status for each row
            $updateQuery = "UPDATE users SET blasting = '$newStatus' WHERE blasting = '$currentStatus'";
            $updateResult = mysqli_query($connection, $updateQuery);

            if (!$updateResult) {
                echo "Error updating blasting status: " . mysqli_error($connection);
                exit; // Exit loop if error occurs
            }
        }

        // All rows updated successfully
        echo "Blasting status updated successfully";
        header('Location: ../admin/sms.php');
        exit;
    } else {
        echo "Error fetching blasting status: " . mysqli_error($connection);
    }
}
?>