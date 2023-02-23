<?php require_once ('php/connection.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <style>
        table { border-collapse: collapse;}
        td, th {border: 1px solid black;}
    </style>
</head>
<body>
    <h1>Select Data</h1>

    <?php 
$sql = "SELECT id,first_name,emp_id, emp_nic FROM employee";

$result = mysqli_query($connection, $sql);


if($result){
    echo mysqli_num_rows($result) . " Records Found <hr>" ; 

    $table = '<table>';
    $table .= '<tr><th>ID</th><th>First Name</th><th>Employee ID</th><th>Employee NIC</th></tr>';
    while($record = mysqli_fetch_assoc($result)){
        $table .= '<tr>';
        $table .= '<td>' . $record['id'] . '</td>';
        $table .= '<td>' . $record['first_name'] . '</td>';
        $table .= '<td>' . $record['emp_id'] . '</td>';
        $table .= '<td>' . $record['emp_nic'] . '</td>';
        $table .= '</tr>';
    
    }
    echo $table;
}
?>
</body>
</html>
<?php mysqli_close($connection); ?>