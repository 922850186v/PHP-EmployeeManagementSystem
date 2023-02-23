<?php require_once ('php/connection.php'); ?>
<?php
$errors = array();
$success = array();
if(isset($_POST['add_salary'])){
    $basic = mysqli_real_escape_string($connection, $_POST['basic']);
    $allow = mysqli_real_escape_string($connection, $_POST['allowance']);
    $emp_id  = mysqli_real_escape_string($connection, $_POST['emp_id']);
    $month  = mysqli_real_escape_string($connection, $_POST['month']);
    $year  = mysqli_real_escape_string($connection, $_POST['year']);

if((empty($basic))){ array_push($errors, "Please enter the Basic Salary") ; }
if(empty($allow)){ array_push($errors, "Please enter the Allowance") ;}
if(empty($emp_id)){ array_push($errors, "Please enter the Employee ID") ;}

//check the user already exists
$check = "SELECT * FROM USER WHERE emp_id='$emp_id'";
$check_result = mysqli_query($connection, $check);

if(mysqli_num_rows($check_result) < 1){
    array_push($errors, "Employee ID does not exists");
}
    if(count($errors) == 0){

    $gross_sal = round(($basic + $allow),2);
    $epf = round(($basic*8/100), 2);
    $net_sal = round(($gross_sal - $epf),2);
    
 $sql = "INSERT INTO salary (emp_idfk,basic,allowance,gross,epf,net_sal,month,year) VALUES ('$emp_id','$basic','$allow','$gross_sal','$epf','$net_sal','$month','$year')" ;

 $result = mysqli_query($connection, $sql);

 if($result)   {
     echo array_push($success, "Salary Added Successfully!");
     header('location: salary.php');
 } else{
     echo array_push($errors, "Error adding Salary");
 }
    }

}
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
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="css\style.css">
    <title>EMS - Add Salary</title>
</head>
<body>
<header>
<div class="heading"><h3>Employee Management System</h3> </div>
<div class="loggedin">Welcome, <?php echo $_SESSION['first_name']?> !<a href="php/logout.php"><strong>Logout</strong></a></div>
</header>
<div class="container">
<h1>Add Salary Details</h1>
<a href="home.php" class="back">Go Back</a>
<form action="add-salary.php" method="post" class="insert-data">
    <table class="user-insert" class="form">
    <tr>
            <td>
                <span for="first_name" class="lables">Employee ID :</span>
            </td>
            <td>
            <input type="number" min="1" name="emp_id" id="emp_id" placeholder="enter the emp_id">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Basic Salary :</span>
            </td>
            <td>
                <input type="number" name="basic" id="first_name" placeholder="enter the Allowance Amount">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Allowance :</span>
            </td>
            <td>
                <input type="number" name="allowance" id="emp_id" placeholder="enter the Allowance Amount">
            </td>
        </tr>   
        <tr>
            <td>
                <span for="first_name" class="lables">Month :</span>
            </td>
            <td>
                <input type="month" min='1' max='12' name="month" id="month" placeholder="enter the Month">
            </td>
        </tr> 
        <tr>
            <td>
                <span for="first_name" class="lables">Year :</span>
            </td>
            <td>
                <input type="month" name="year" id="year" placeholder="enter the Year">
            </td>
        </tr> 
        

    </table>
    <input type="submit" name="add_salary" value="Add Salary" class ="btn">
    <?php include ('php/errors.php'); ?>
</form>
</div>
</body>
</html>