<?php
function connect($root, $pass) {
    try {
        $conn = new PDO('mysql:host=localhost; dbname=oborkita_db',$root, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch(Exception $e) {
        return false;
    }
}

# 	Example:
 
if ( connect('ok_user', 'dx3QpXaD+J54') ) {
         // Execute Statement
         echo "konek";
} else {
    echo "failed";
}