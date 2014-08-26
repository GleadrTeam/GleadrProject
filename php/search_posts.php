<?php
include_once("sqlconnect.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search SoftUni Overflow</title>
</head>
<body>
<h1>Search Results</h1>
<?php
    if(!empty($_GET['term'])) {
        $search_results = (searchPosts($_GET['term']));

        echo "Your search has returned " . count($search_results) . " results<br/>";

        if(empty($search_results)) {
            echo "No results!";
        }

        foreach ($search_results as $result) {
            echo '<a href=view_category.php?cid=' . $result["category_id"] . '><h3>' . $result["topic_title"] . '</h3></a>';
        }

    } else {
        echo "No results!<br/><br/>";
    }
    echo "<a href='index.php'>Return To Forum Index</a><hr/>";
?>
</body>
</html>