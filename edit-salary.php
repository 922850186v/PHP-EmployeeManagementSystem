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

$errors = array(); 
$success = array();

if(isset($_GET['id'])){

    $user_id = mysqli_real_escape_string($connection, $_GET['id']);
    $query = "SELECT * FROM SALARY WHERE emp_idfk = '$user_id' LIMIT 1";

    $resultset = mysqli_query($connection, $query);

    $emp_sql = "SELECT * FROM SALARY WHERE emp_idfk = '$user_id' LIMIT 1";
    $emp_check = mysqli_query($connection,$emp_sql );
    if($resultset){
        if(mysqli_num_rows($resultset) == 1){
            $user = mysqli_fetch_assoc($resultset);

        }else{
            header('location: home.php?err=user_not_found');
        }
    }else{
        header('location: home.php?err=query_failed');
    }
}

if(isset($_POST['edit_salary'])){

    $basic = mysqli_real_escape_string($connection, $_POST['basic']);
    $emp_id  = mysqli_real_escape_string($connection, $_POST['emp_id']);
    $allowance = mysqli_real_escape_string($connection, $_POST['allowance']);
    


if((empty($basic))){ array_push($errors, "Enter the Basic Salary") ; }
if(empty($allowance)){ array_push($errors, "Enter the Allowance") ;}

    if(count($errors) == 0){

$gross = $basic + $allowance;
$epf = $basic*8/100;
$net_sal = $gross - $epf;
 $sql = "UPDATE salary SET basic='$basic',allowance='$allowance',gross='$gross',epf='$epf',net_sal='$net_sal' where emp_idfk='$emp_id'" ;

 $result = mysqli_query($connection, $sql);
 $check = "SELECT * FROM USER WHERE emp_id='$emp_id'";
 $check_result = mysqli_query($connection, $check);
 
 if(mysqli_num_rows($check_result) < 1){
     array_push($errors, "Employee ID does not exists");
 }
 if(($result))   {
     echo array_push($success, "User Added Successfully!");
     header('location: salary.php');
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
    <title>EMS - Salary Edit</title>
</head>
<body>
<header>
<div class="heading"><h3>Employee Management System</h3> </div>
<div class="loggedin">Welcome, <?php echo $_SESSION['first_name']?> !<a href="php/logout.php"><strong>Logout</strong></a></div>
</header>

<div class="container">
<h1>Edit Salary Details</h1>
<a href="salary.php" class="back">Go Back</a>
<form action="edit-salary.php" method="post" class="insert-data">
    <table class="user-insert" class="form">
    <tr>
            <td>
                <span for="first_name" class="lables">Employee ID :</span>
            </td>
            <td>
              <input type="number" min="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['emp_idfk'];
                                  }
                                   
                                  ?>" max="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['emp_idfk'];
                                  }
                                   
                                  ?>" name="emp_id" id="emp_id" value="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['emp_idfk'];
                                  }
                                   
                                  ?>">
            </td>
        </tr>
        <tr>
            <td>
                <span for="basic" class="lables">Basic Salary :</span>
            </td>
            <td>
                <input type="number" name="basic" id="first_name" value="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['basic'];
                                  }
                                   
                                  ?>">
            </td>
        </tr>
        <tr>
            <td>
                <span for="first_name" class="lables">Allowance :</span>
            </td>
            <td>
                <input type="number" name="allowance" id="last_name" value="<?php 
                                  
                                  $result_get = mysqli_query($connection, $query);
                                  while($value = mysqli_fetch_assoc($result_get)){
                                      echo $value['allowance'];
                                  }
                                   
                                  ?>">
            </td>
        </tr>
        

    </table>
    <input type="submit" name="edit_salary" value="Edit Salary Details" class ="btn">
    <?php include ('php/errors.php'); ?>
</form>
</div>
</body>
</html>