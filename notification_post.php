<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);


    // Validate.
    if(trim($request->notification) === '')
    {
        return http_response_code(400);
    }

    // Sanitize.
    $notification = mysqli_real_escape_string($con, trim($request->notification));
    $notification_date = date('m/d/Y h:i:s a', time());


    // Create.
    $sql = "INSERT INTO `notifications`(`id`,`notification`, `notification_date`) VALUES (null,'{$notification}','{$notification_date}')";

    if(mysqli_query($con,$sql))
    {
        http_response_code(201);
        $policy = [
            'notification' => $notification,
            'notification_date' => $notification_date,
            'id'    => mysqli_insert_id($con)
        ];
        echo json_encode($policy);
    }
    else
    {
        http_response_code(422);
    }
}