<?php require_once ('php/connection.php'); ?>
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
<?php 
//define variables
$username    = "";
$password    = "";

$errors = array(); 
$success = array();
//create user
if(isset($_POST['create'])){

      $fname = mysqli_real_escape_string($connection, $_POST['first_name']);
      $lname = mysqli_real_escape_string($connection, $_POST['last_name']);
    //   $emp_id  = mysqli_real_escape_string($connection, $_POST['emp_id']);
      $emp_nic = mysqli_real_escape_string($connection, $_POST['emp_nic']);
      $email = mysqli_real_escape_string($connection, $_POST['email']);
      $password = mysqli_real_escape_string($connection, $_POST['password']);
      $role = mysqli_real_escape_string($connection, $_POST['role']);


if((empty($fname))){ array_push($errors, "Please enter the First Name") ; }
if(empty($lname)){ array_push($errors, "Please enter the Last Name") ;}
// if(empty($emp_id)){ array_push($errors, "Please enter the Employee ID") ;}
if(empty($emp_nic)){ array_push($errors, "Please enter the Employee NIC") ;}
if(empty($email)){ array_push($errors, "Please enter the Email") ;} 
if(empty($password)){ array_push($errors, "Please enter the password") ;}

//CHECK THE USER IN DB
$check = "SELECT * FROM USER WHERE emp_nic='$emp_nic'";
$check_result = mysqli_query($connection, $check);

if(($check_result)){
 array_push($errors, "User Already Exists!");
}
    if(count($errors) == 0){
       
            session_regenerate_id();
   
            $session_id = session_id();
           
            $sql = "INSERT INTO user (first_name,last_name,email,password,session_id) VALUES ('$fname','$lname','$email','$password','$session_id')" ;
         
            $result = mysqli_query($connection, $sql);
         
            if($result)   {
         
             $sql2 = "INSERT INTO EMPLOYEE (emp_nic,role) VALUES ('$emp_nic','$role')";
             $result2 = mysqli_query($connection, $sql2);
                //  $_SESSION['success'] = "User Added Successfully!";
                header('location: home.php');
            } else{
                echo array_push($errors, "Error adding user");
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
    <title>EMS - Add New User</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
<div class="heading"><h3>Employee Management System</h3> </div>
<div class="loggedin">Welcome, <?php echo $_SESSION['first_name']?> !<a href="index.php?logout='1'"><strong>Logout</strong></a></div>
</header>

<div class="container">
<h1>Add New User</h1>

<a href="home.php" class="back">Go Back</a>
<form action="insert.php" method="post" class="insert-data">
    <table class="user-insert" class="form">
        
        <tr>
            <td>
                <span for="first_name" class="lables">First Name :</span>
            </td>
            <td>
                <input type="text" name="first_name" id="first_name" placeholder="enter the First Name">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Last Name :</span>
            </td>
            <td>
                <input type="text" name="last_name" id="first_name" placeholder="enter the First Name">
            </td>
        </tr>
        
        <tr>
            <td>
                <span for="first_name" class="lables">Employee NIC :</span>
            </td>
            <td>
                <input type="text" min-lenght ='10' name="emp_nic" id="emp_nic" placeholder="enter the First Name">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Email :</span>
            </td>
            <td>
                <input type="text" name="email" id="email" placeholder="enter the First Name">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Defualt Password :</span>
            </td>
            <td>
                <input type="PASSWORD" name="password" id="password" placeholder="enter the First Name">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">User Role :</span>
            </td>
            <td>
                <select name="role" id="role" class="role">
                    <option value="user">User</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="admin">Administrator</option>
                </select>
            </td>
        </tr>
        
        

    </table>
    <input type="submit" name="create" value="Create User" class ="btn">
    <?php include ('php/errors.php'); ?>
</form>
</div>


</body>
</html>
<?php mysqli_close($connection); ?>