
<?php include_once('php/connection.php'); ?>
<?php 
error_reporting(0);
$errors = array(); 
$success = array();
//login user
if(isset($_POST['login'])){


    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
   
    
   //check whether the fields are empty
    if((empty($username)) && empty($password)){
           array_push($errors, "Please enter the Username & Password") ;
   
    }elseif(empty($password)){
       
           array_push($errors, "Please enter the Password") ;
        
    }elseif(empty($username)){
           array_push($errors, "Please enter the Username") ;
    }
   
    if(count($errors) == 0){
          
          $query = "SELECT * FROM USER WHERE email='$username'and password='$password'";
          $result = mysqli_query($connection , $query);
          $user = mysqli_fetch_assoc($result);
          if($user['deactivated'] > 0){
            array_push($errors, "Deactivated User. Please contact the Admin");
        }
            if(mysqli_num_rows($result) == 1){
                
                    session_regenerate_id();
                    $session_id = session_id();
                    $sql = "UPDATE user SET session_id='$session_id' WHERE email='$username'";
                    mysqli_query($connection, $sql);
                           $_SESSION['deactivated'] = $user['deactivated'];
                           $_SESSION['success'] = "Successful submitted!";
                           $_SESSION['first_name'] = $user['first_name'];
                           $_SESSION['emp_id'] = $user['emp_id'];
                           $_SESSION['session_id'] = $user['session_id'];
                           header('location:home.php');
                }      
                 else{
                       array_push($errors , "Wrong Password for the User");
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
    <title>Employee Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
    <div class="heading"><h3>Employee Management System</h3></div>
</header>
    <form class="insert-data" action="index.php" method="post">
    
        <h2>Login Here</h2>
        <?php include_once('php/errors.php'); ?>
        <?php if (isset($_GET['logout'])) {
    echo "<p class='success'>You have Successfully logged out </p>";
    session_destroy();
    unset($_SESSION['emp_id']);
    header("location: index.php");
}
?>
        <table class="form">
            <tr>
                <td class="rows">Username :</td>
                <td class="input">
                    <input type="text" name="username" id="username" placeholder="Employee email Here">
                </td>
            </tr>
            <tr>
                <td class="rows">Password :</td>
                <td class="input">
                    <input type="password" name="password" id="password" placeholder="Password Here">
                </td>
            </tr>
            
        </table>
        <input type="submit" name="login" value="Login Here!" class ="btn">
    </form>
</body>
</html>