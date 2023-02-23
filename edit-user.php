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


if(isset($_GET['user_id'])){
error_reporting(0);
    $user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
    $query = "SELECT * FROM USER WHERE emp_id = '$user_id'";

    $resultset = mysqli_query($connection, $query);

    $emp_sql = "SELECT * FROM EMPLOYEE WHERE emp_id = '$user_id' LIMIT 1";
    $emp_check = mysqli_query($connection,$emp_sql );
    if($resultset){
        if(mysqli_num_rows($resultset) == 1){
            $user = mysqli_fetch_assoc($resultset);

            $fname = $user['first_name'];
            $lname = $user['last_name'];
            $emp_id = $user['emp_id'];
        }else{
            header('location: home.php?err=user_not_found');
        }
    }else{
        header('location: home.php?err=query_failed');
    }
}


$errors = array(); 
$success = array();

$user_id="";

if(isset($_POST['edit'])){

    $fname = mysqli_real_escape_string($connection, $_POST['first_name']);
    $lname = mysqli_real_escape_string($connection, $_POST['last_name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);
    $id = mysqli_real_escape_string($connection, $_POST['emp_id']);

if((empty($fname))){ array_push($errors, "Please enter the First Name") ; }
if(empty($lname)){ array_push($errors, "Please enter the Last Name") ;}

// if(empty($emp_nic)){ array_push($errors, "Please enter the Employee NIC") ;}
if(empty($email)){ array_push($errors, "Please enter the Email") ;} 
if(empty($password)){ array_push($errors, "Please enter the Password") ;}

    if(count($errors) == 0){

        $check = "SELECT * FROM USER WHERE emp_id='$id'";
        $check_result = mysqli_query($connection, $check);
        
        if(mysqli_num_rows($check_result) < 1){
            array_push($errors, "Employee ID does not exists");
        }
 $sql = "UPDATE user SET first_name='$fname',last_name='$lname',email='$email',password='$password',deactivated='$status' WHERE emp_id='$id'" ;

 $result = mysqli_query($connection, $sql);

 if($result) {
    // $sql2 = "UPDATE EMPLOYYE SET role='$role'";
    // $result2 = mysqli_query($connection, $sql2);
    //  echo array_push($success, "User Added Successfully!");
     header('locaion: home.php');
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
    <link rel="stylesheet" href="css/style.css">
    <title>EMS - Details Edit</title>
</head>
<body>
<header>
<div class="heading"><h3>Employee Management System</h3> </div>
<div class="loggedin">Welcome, <?php echo $_SESSION['first_name']?> !<a href="php/logout.php"><strong>Logout</strong></a></div>
</header>

<div class="container">
<h1>Edit User Details</h1>
<a href="home.php" class="back">Go Back</a>
<div class="container">
    <form action="edit-user.php" method="post">
        <table>
         
        <tr >
            <td>
                <span for="emp_id" class="lables">Employee ID :</span>
            </td>
            <td>
                <span for ="emp_id" id="emp_id" ><strong><?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['emp_id'];
                                  }
                                   
                                  ?></strong></span>
            </td>
        </tr>
        <tr>
            <td>
                <span for="emp_id" class="lables"></span>
            </td>
            <td>
                <input type ="hidden" name="emp_id" id="emp_id" value="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['emp_id'];
                                  }
                                   
                                  ?>">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">First Name :</span>
            </td>
            <td>
                <input type="text" name="first_name" id="first_name" value="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['first_name'];
                                  }
                                   
                                  ?>">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Last Name :</span>
            </td>
            <td>
                <input type="text" name="last_name" id="last_name" value="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['last_name'];
                                  }
                                   
                                  ?>">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Profile Status :</span>
            </td>
            <td>
                <input type="number" max='1' min='0' name="status" id="status" value="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['deactivated'];
                                  }
                                   
                                  ?>">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Email :</span>
            </td>
            <td>
                <input type="text" name="email" id="email" value="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['email'];
                                  }
                                   
                                  ?>">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Defualt Password :</span>
            </td>
            <td>
                <input type="text" name="password" id="password" value="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['password'];
                                  }
                                   
                                  ?>">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">User Role :</span>
            </td>
            <td>
                <select name="role" id="">
                    <option value="user">User</option>
                    <option value="supervisor">Supervisor</option>
                    <option value="admin">Administrator</option>
                </select>
            </td>
        </tr>
        
        

        </table>
        <input type="submit" name="edit" value="Edit User" class ="btn">
    </form>
 
</div>
        
    
    <?php include ('php/errors.php'); ?>
</form>
</div>
</body>
</html>