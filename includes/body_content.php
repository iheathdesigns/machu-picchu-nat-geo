
<?php 
		//include variables to add scope

		include('needed_variables.php');

		//conditional script - is else if else
		if($section == 'home'){//home w/no url parameter
			include('content/home.php');
	
		}else if($section != '-1' || $section != 'home'){
			include("content/$section.php");
	
		}else{
			include('index.php');
}

?>


