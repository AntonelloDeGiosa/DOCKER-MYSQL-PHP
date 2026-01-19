<?php
    setcookie("username", $_POST["username"], time()+60*60*24*7);
    setcookie("theme", $_POST["theme"], time()+60*60*24*7);
    header("Location: set_cookie.php");


    echo $username;
    echo $theme;
    
  


?>