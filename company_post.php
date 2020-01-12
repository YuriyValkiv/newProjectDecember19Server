<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);


    // Validate.
    if(trim($request->characteristic) === '' || trim($request->characteristic_value) === '' || trim($request->characteristic_type) === '')
    {
        return http_response_code(400);
    }

    // Sanitize.
    $characteristic = mysqli_real_escape_string($con, trim($request->characteristic));
    $characteristic_value = mysqli_real_escape_string($con, trim($request->characteristic_value));
    $characteristic_type = mysqli_real_escape_string($con, trim($request->characteristic_type));


    // Create.
    $sql = "INSERT INTO `company`(`id`,`characteristic`,`characteristic_value`,`characteristic_type`) VALUES (null,'{$characteristic}','{$characteristic_value}','{$characteristic_type}')";

    if(mysqli_query($con,$sql))
    {
        http_response_code(201);
        $policy = [
            'characteristic' => $characteristic,
            'characteristic_value' => $characteristic_value,
            'characteristic_type' => $characteristic_type,
            'id'    => mysqli_insert_id($con)
        ];
        echo json_encode($policy);
    }
    else
    {
        http_response_code(422);
    }
}