<?php
	// This file is the place to store all basic functions
	
	function mysql_prep($value){ 
		return mysql_real_escape_string(stripslashes($value)); 
	}

    function validate_datetime ($datetime)
    {
        if ( function_exists('date_default_timezone_set') ) {
            date_default_timezone_set('GMT');
        }
        return strtotime($datetime) !== -1;
    }

?>