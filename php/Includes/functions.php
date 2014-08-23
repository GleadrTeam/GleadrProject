<?php
	// This file is the place to store all basic functions
	
	function mysql_prep($value){ 
		return mysql_real_escape_string(stripslashes($value)); 
	}



?>