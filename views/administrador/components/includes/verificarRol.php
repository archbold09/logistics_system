<?php
//valida que este iniciada la sesion
if(!isset($_SESSION['rol'])){
	    header('location: ../../index.php');	
    }//valida que el rol sea admin
    else{
	if($_SESSION['rol'] != 1){
		header('location: ../../index.php');
	}
}
?>