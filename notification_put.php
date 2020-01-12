<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);

    // Validate.
    if ((int)$request->id < 1 || trim($request->notification) === '') {
        return http_response_code(400);
    }

    // Sanitize.
    $id    = mysqli_real_escape_string($con, (int)$request->id);
    $notification = mysqli_real_escape_string($con, trim($request->notification));
    $notification_date = date('m/d/Y h:i:s a', time());

    // Update.
    $sql = "UPDATE `notifications` SET `notification`='$notification', `notification_date`='$notification_date' WHERE `id` = '{$id}' LIMIT 1";

    if(mysqli_query($con, $sql))
    {
        http_response_code(204);
    }
    else
    {
        return http_response_code(422);
    }
}