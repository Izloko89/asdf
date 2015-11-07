<?php
	try{
		move_uploaded_file($_FILES["image"]["tmp_name"], '../img/imagenCliente/'. $_FILES["image"]["name"]);
	}
	catch(Exception $err)
	{
		echo $err->getMessage();
	}
?>