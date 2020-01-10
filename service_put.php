<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);

    // Validate.
    if ((int)$request->id < 1 || trim($request->service_name) == '') {
        return http_response_code(400);
    }

    // Sanitize.
    $id    = mysqli_real_escape_string($con, (int)$request->id);
    $service_name = mysqli_real_escape_string($con, trim($request->service_name));

    // Update.
    $sql = "UPDATE `services` SET `service_name`='$service_name' WHERE `id` = '{$id}' LIMIT 1";

    if(mysqli_query($con, $sql))
    {
        http_response_code(204);
    }
    else
    {
        return http_response_code(422);
    }
}