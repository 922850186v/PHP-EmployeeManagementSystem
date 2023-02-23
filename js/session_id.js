function check_session_id()
{
    var session_id = "<?php echo $_SESSION['session_id']; ?>";

    fetch ('check_login.php').then (function(response){

        {
            return response.json();
        }
    }).then(function(responseData){
       if(responseData.output == 'logout')
       {
        window.location.href = 'logout.php';
       }
    });
    

}

setInterval(function(){
    check_session_id();

}, 1000);