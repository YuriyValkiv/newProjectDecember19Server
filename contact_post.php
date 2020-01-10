<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);


    // Validate.
    if(trim($request->contact) === '')
    {
        return http_response_code(400);
    }

    // Sanitize.
    $contact = mysqli_real_escape_string($con, trim($request->contact));


    // Create.
    $sql = "INSERT INTO `contacts`(`id`,`contact`) VALUES (null,'{$contact}')";

    if(mysqli_query($con,$sql))
    {
        http_response_code(201);
        $policy = [
            'contact' => $contact,
            'id'    => mysqli_insert_id($con)
        ];
        echo json_encode($policy);
    }
    else
    {
        http_response_code(422);
    }
}