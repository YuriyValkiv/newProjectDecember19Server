<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);


    // Validate.
    if(trim($request->service_name) === '' || trim($request->service_type) === '')
    {
        return http_response_code(400);
    }

    // Sanitize.
    $service_name = mysqli_real_escape_string($con, trim($request->service_name));
    $service_type = mysqli_real_escape_string($con, trim($request->service_type));


    // Create.
    $sql = "INSERT INTO `services`(`id`,`service_name`,`service_type`) VALUES (null,'{$service_name}','{$service_type}')";

    if(mysqli_query($con,$sql))
    {
        http_response_code(201);
        $policy = [
            'service_name' => $service_name,
            'service_type' => $service_type,
            'id'    => mysqli_insert_id($con)
        ];
        echo json_encode($policy);
    }
    else
    {
        http_response_code(422);
    }
}