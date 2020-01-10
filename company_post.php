<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);


    // Validate.
    if(trim($request->characteristic) === '' || (float)$request->characteristic_value < 0)
    {
        return http_response_code(400);
    }

    // Sanitize.
    $characteristic = mysqli_real_escape_string($con, trim($request->characteristic));
    $characteristic_value = mysqli_real_escape_string($con, (int)$request->characteristic_value);


    // Create.
    $sql = "INSERT INTO `company`(`id`,`characteristic`,`characteristic_value`) VALUES (null,'{$characteristic}','{$characteristic_value}')";

    if(mysqli_query($con,$sql))
    {
        http_response_code(201);
        $policy = [
            'characteristic' => $characteristic,
            'characteristic_value' => $characteristic_value,
            'id'    => mysqli_insert_id($con)
        ];
        echo json_encode($policy);
    }
    else
    {
        http_response_code(422);
    }
}