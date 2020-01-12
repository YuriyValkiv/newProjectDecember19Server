<?php
/**
 * Returns the list of policies.
 */
require 'database.php';

$contacts = [];
$sql = "SELECT * FROM contacts";

if($result = mysqli_query($con,$sql))
{
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
    {
        $contacts[$i]['id'] = $row['id'];
        $contacts[$i]['contact'] = $row['contact'];
        $contacts[$i]['contact_type'] = $row['contact_type'];
        $i++;
    }

    echo json_encode($contacts);
}
else
{
    http_response_code(404);
}