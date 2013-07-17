<?php
   
   session_start(); 
    unset ($_SESSION['fb_token']); 
    unset ($_SESSION['fb_expires']); 
    unset ($_SESSION['li_token']); 
    unset ($_SESSION['li_expires']);
    unset ($_SESSION['fs_token'] );
    unset ($_SESSION['fs_expires']);
	unset ($_SESSION['claimed_id']);
	unset ($_SESSION['email']);
 echo "sessions Released";

?>