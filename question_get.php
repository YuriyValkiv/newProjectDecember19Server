<?php
/**
 * Returns the list of policies.
 */
require 'database.php';

$questions = [];
$sql = "SELECT * FROM questions ORDER BY question_date DESC";

if($result = mysqli_query($con,$sql))
{
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
    {
        $questions[$i]['id'] = $row['id'];
        $questions[$i]['question_author'] = $row['question_author'];
        $questions[$i]['question'] = $row['question'];
        $questions[$i]['question_date'] = $row['question_date'];
        $questions[$i]['answer'] = $row['answer'];
        $i++;
    }

    echo json_encode($questions);
}
else
{
    http_response_code(404);
}