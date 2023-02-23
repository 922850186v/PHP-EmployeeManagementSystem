<?php require_once ('php/connection.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
</head>
<body>
    <h1>Update Data</h1>

<?php
$sql = "UPDATE employee SET first_name='Hiran' where id='2'";

$result = mysqli_query($connection, $sql);
if($result){

    echo mysqli_affected_rows($connection) . " Records Updated.";
}else{
    echo "Connection Error";
}
?>
</body>
</html>
<?php mysqli_close($connection); ?>