<?php 
    // Set title of pages function
    function setTitle(){
        global $title;
        if(isset($title)){
            echo $title;
        } else {
            echo "Default";
        }
    }
    // Count item function
    function countItem($item, $table){
        global $con;
        $stmt = $con->prepare("SELECT COUNT($item) FROM $table");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    // Sum of rows function
    function sumItem($item, $table){
        global $con;
        $stmt = $con->prepare("SELECT SUM($item) FROM $table");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
?>