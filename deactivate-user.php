<?php require_once ('php/connection.php'); ?>
<?php 
if(!isset($_SESSION['session_id'])){
    unset($_SESSION['session_id']);
    header("location: index.php");

}
if (isset($_GET['logout'])) {
    echo "<p class='success'>You have Successfully logged out </p>";
    session_destroy();
    unset($_SESSION['session_id']);
    header("location: index.php");
}
?>
<?php
$errors = array();
$success = array();
if(isset($_POST['deactivate'])){
    $emp_id = mysqli_real_escape_string($connection, $_POST['emp_id']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    
if((empty($emp_id))){ array_push($errors, "Please enter the Employee ID") ; }
if(empty($status)){ array_push($errors, "Please enter the Status") ;}


//check the user already exists
$check = "SELECT * FROM EMPLOYEE WHERE emp_id='$emp_id'";
$check_result = mysqli_query($connection, $check);

if(mysqli_num_rows($check_result) < 1){
    array_push($errors, "Employee ID does not exists");
}
    if(count($errors) == 0){
    
 $sql = "UPDATE USER SET deactivated='$status' WHERE emp_id='$emp_id'" ;

 $result = mysqli_query($connection, $sql);

 if($result)   {
    //  echo array_push($success, "Deactivated Successfully!");
     header('location: home.php');
 } else{
     echo array_push($errors, "Error adding Salary");
 }
}

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
<div class="heading"><h3>Employee Management System</h3> </div>
<div class="loggedin">Welcome, <?php echo $_SESSION['first_name']?> !<a href="php/logout.php"><strong>Logout</strong></a></div>
</header>
<div class="container">
<h1>Deactivate / Activate User</h1>
<a href="home.php" class="back">Go Back</a>
<div class="container">
    <form action="deactivate-user.php" method="post">
    <table>
    <tr>
        <td>
            <span>Employee ID</span>
        </td>
        <td>
        <input type="number" min='1' name="emp_id" id="emp_id">
        </td>
    </tr>
    <tr>
        <td>
            <span>Employee Status :</span>
        </td>
        <td>
        <input type="number" min='0' max = '1' name="status" id="status">
        </td>
    </tr>
</table>
<input type="submit" value="deactivate" class='btn'>
</form>

</div>

</div>
</body>
</html>
<?php mysqli_close($connection); ?>