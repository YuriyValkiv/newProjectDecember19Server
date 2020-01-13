<?php
require 'database.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
    // Extract the data.
    $request = json_decode($postdata);

    // Validate.
    if ((int)$request->id < 1 || trim($request->question_author) === '' || trim($request->question) === '' || trim($request->answer) === '') {
        return http_response_code(400);
    }

    // Sanitize.
    $id    = mysqli_real_escape_string($con, (int)$request->id);
    $question_author = mysqli_real_escape_string($con, trim($request->question_author));
    $question = mysqli_real_escape_string($con, trim($request->question));
    $question_date = date('m/d/Y h:i:s', time());
    $answer = mysqli_real_escape_string($con, trim($request->answer));
    $answer_date = date('m/d/Y h:i:s', time());

    // Update.
    $sql = "UPDATE `questions` SET `question_author`='$question_author', `question`='$question', `answer`='$answer', `answer_date`='$answer_date' WHERE `id` = '{$id}' LIMIT 1";

    if(mysqli_query($con, $sql))
    {
        http_response_code(204);
    }
    else
    {
        return http_response_code(422);
    }
}