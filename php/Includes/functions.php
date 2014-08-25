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

    function searchPosts($term) {
        $keywords = preg_split("/\s+/", mysql_real_escape_string($term));

        $title_where = "topic_title LIKE '%". implode("%' OR topic_title LIKE '%", $keywords) ."%'";

        $sql = "SELECT topic_title, category_id FROM topics WHERE {$title_where}";
        $result = mysql_query($sql) or die(mysql_error());
        $results = array();

        while($row = mysql_fetch_assoc($result)) {
            $results[] = $row;
        }

        return $results;
    }

?>