<?php
/**
 * Returns the list of policies.
 */
require 'database.php';

$services = [];
$sql = "SELECT * FROM services";

if($result = mysqli_query($con,$sql))
{
    $i = 0;
    while($row = mysqli_fetch_assoc($result))
    {
        $services[$i]['id'] = $row['id'];
        $services[$i]['service_name'] = $row['service_name'];
        $i++;
    }

    echo json_encode($services);
}
else
{
    http_response_code(404);
}