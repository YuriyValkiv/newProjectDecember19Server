<?php
/**
 * Returns the list of policies.
 */
require 'database.php';

$characteristics = [];
$sql = "SELECT * FROM company";

if($result = mysqli_query($con,$sql))
{
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
    {
        $characteristics[$i]['id'] = $row['id'];
        $characteristics[$i]['characteristic'] = $row['characteristic'];
        $characteristics[$i]['characteristic_value'] = $row['characteristic_value'];
        $i++;
    }

    echo json_encode($characteristics);
}
else
{
    http_response_code(404);
}