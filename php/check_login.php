<?php include('connection.php');

    $check_login = "SELECT session_id FROM user WHERE emp_id='".$_SESSION['emp_id']."'";

    $output = mysqli_query($connection, $check_login);
    $val = mysqli_num_rows($output);
    // echo $val;
    foreach($output as $row){
        if($_SESSION['session_id'] != $row['session_id']){
            $data['output'] = 'logout';
        }else{
            $data['output'] = 'login';
        }
    }

    echo json_encode($data);
?>