<?php	
	require 'libs/rb.php';
	R::setup( 'mysql:host=localhost;dbname=users_db',
       'root', '' );
	$connection = new PDO('mysql:host=localhost;dbname=users_db', 'root', '');
    
?>