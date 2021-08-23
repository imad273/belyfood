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
    
?>