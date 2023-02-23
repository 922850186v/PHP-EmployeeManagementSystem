<?php 
require_once ('php/connection.php'); 
?>
<?php 
//check the user whether logged in
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
    <title>Employee Management System</title>
    <link rel="stylesheet" href="css\style.css">
    <style>
        table { border-collapse: collapse;}
        td, th {
            border-bottom: 1px solid #c3c6ff;
            padding: 1%;
            width:0.5%;
        }
    </style>
</head>
<header>
<div class="heading"><h3>Employee Management System</h3> </div>
<div class="loggedin">Welcome, <strong><?php echo $_SESSION['first_name']?></strong>  | <a href="php/logout.php"><strong style="color:firebrick;">Logout</strong></a></div>
</header>


<div class="container">
<h1>Employee Details</h1>
<span class="adduser">
    <a href="insert.php">Add New User</a>
</span>
<div class="table">
<?php 
$sql = "SELECT * FROM user,employee where user.emp_id = employee.emp_id";
$result = mysqli_query($connection, $sql);
if($result){
    // echo mysqli_num_rows($result) . " Records Found <hr>" ; 

    $table = '<table>';
    $table .= '<tr><th>Employee ID</th><th>First Name</th><th>Last Name</th><th>Employee NIC</th><th>User Role</th><th>User Status</th></tr>';
    while($record = mysqli_fetch_assoc($result)){
        // $record['emp_id'] = $_SESSION['user'];
        if($record['deactivated']<1){
            $status = "Active";
        }else{
            $status = "Deactivated";
        }
        $table .= '<tr>';
        $table .= '<td><a href="salary.php">' . $record['emp_id'] . '</td>';
        $table .= '<td>' . $record['first_name'] . '</td>';
        $table .= '<td>' . $record['last_name'] . '</td>';
        $table .= '<td>' . $record['emp_nic'] . '</td>';
        $table .= '<td>' . $record['role'] . '</td>';
        $table .= '<td>' . $status . '</td>';
        $table .= "<td><a href=\"edit-user.php?user_id={$record['emp_id']}\">Edit</a></td>";
        $table .= '</tr>';

    }
    echo $table;
    
}
// echo "Session ID : ";
// echo $_SESSION['session_id'];
?>

</div>

</div>
<strong style=color:firebrick;>* Click the Employee ID to check Salary Details</strong>
</html>
<?php 
mysqli_close($connection); 
?>
<script>
    function check_session_id()
{
    var session_id = "<?php echo $_SESSION['session_id']; ?>";

    fetch ('php\check_login.php').then (function(response){

        {
            return response.json();
        }
    }).then(function(responseData){
       if(responseData.output == 'logout')
       {
        window.location.href = 'php\logout.php';
       }
    });
    

}

setInterval(function (){
    check_session_id();

}, 3000);
</script>
