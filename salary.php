<?php require_once ('php/connection.php'); ?>

<?php 
$errors = array(); 
$success = array();

$sql = "SELECT * FROM salary";
$emp = "SELECT * FROM USER";
$resultset = mysqli_query($connection, $sql);
$resultemp = mysqli_query($connection, $emp);
$emp_id = mysqli_fetch_assoc($resultemp);
?>
<?php 
if(!isset($_SESSION['session_id'])){
    unset($_SESSION['session_id']);
    header("location: index.php");
header('location: index.php');
}
if (isset($_GET['logout'])) {
    echo "<p class='success'>You have Successfully logged out </p>";
    session_destroy();
    unset($_SESSION['session_id']);
    header("location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\style.css">
    <title>EMS - Salary Details</title>
    <style>
        table { border-collapse: collapse;}
        td, th {
            border-bottom: 1px solid #aaa;
            padding: 1%;
            width:0.5%;
        }
    </style>
</head>

<body>
<header>
<div class="heading"><h3>Employee Management System</h3> </div>
<div class="loggedin">Welcome, <?php echo $_SESSION['first_name']?> !<a href="php/logout.php"><strong>Logout</strong></a></div>
</header>
<div class="container">
<h1>Salary Details</h1>
<a href="home.php" class="back">Go Back</a><br><br>
<span class="adduser">
    <a href="add-salary.php">Add User Salary</a>
</span>

<div class="table">
    <?php  $table = '<table>';
    $table .= '<tr><th>Employee ID</th><th>Basic Salary</th><th>Allowance</th><th>Gross Salary</th><th>EPF</th><th>Net Salary</th></tr>';
    while($record = mysqli_fetch_assoc($resultset)){
        $gross = round(($record['basic'] + $record['allowance']), 2);
        $epf = round((($record['basic'])*(8/100)), 2);
        $net = round(($gross - $epf), 2);
        $table .= '<tr>';
        $table .= '<td>' . $record['emp_idfk']  . '</td>';
        $table .= '<td>' . 'Rs.'. $record['basic'] .'/-'. '</td>';
        $table .= '<td>' . 'Rs.'. $record['allowance'] .'/-'. '</td>';
        $table .= '<td>' . 'Rs.'. $gross .'/-'. '</td>';
        $table .= '<td>' . 'Rs.'. $epf .'/-'. '</td>';
        $table .= '<td>' . 'Rs.'. $net .'/-'. '</td>';

        $table .= "<td><a href=\"edit-salary.php?id={$record['emp_idfk']}\">Edit</a></td>";
        
        $table .= '</tr>';
        
    }
    echo $table;?>

</div>

</div>

</body>
</html>