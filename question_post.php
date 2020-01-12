<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");
date_default_timezone_set('Europe/Kiev');

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);


    // Validate.
    if(trim($request->question_author) === '' || trim($request->question) === '')
    {
        return http_response_code(400);
    }

    // Sanitize.
    $question_author = mysqli_real_escape_string($con, trim($request->question_author));
    $question = mysqli_real_escape_string($con, trim($request->question));
    $question_date = date('m/d/Y h:i:s a', time());
    $answer = mysqli_real_escape_string($con, trim($request->answer));


    // Create.

    $sql = "INSERT INTO `questions`(`id`,`question_author`, `question`, `question_date`, `answer`) VALUES (null,'{$question_author}','{$question}','{$question_date}','{$answer}')";


    if(mysqli_query($con,$sql))
    {
        http_response_code(201);
        $policy = [
            'question_author' => $question_author,
            'question' => $question,
            'question_date' => $question_date,
            'answer' => null,
            'id'    => mysqli_insert_id($con)
        ];
        echo json_encode($policy);
    }
    else
    {
        http_response_code(422);
    }
}