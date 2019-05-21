<?php

    function OpenCon()
    {

        $dbhost = "localhost";
        $dbuser = "kiko";
        $dbpass = "llgX4rBxbL85aKpa";
        $db = "bookstore_v1";
        $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
        
        return $conn;

    }
    
    function CloseCon($conn)
    {

        $conn -> close();
        
    }
       
?>