<?php
/**
 * Returns the list of policies.
 */
require 'database.php';

$notifications = [];
$sql = "SELECT * FROM notifications ORDER BY notification_date DESC";

if($result = mysqli_query($con,$sql))
{
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
    {
        $notifications[$i]['id'] = $row['id'];
        $notifications[$i]['notification'] = $row['notification'];
        $notifications[$i]['notification_date'] = $row['notification_date'];
        $i++;
    }

    echo json_encode($notifications);
}
else
{
    http_response_code(404);
}