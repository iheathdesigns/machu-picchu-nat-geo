<?php 


include('needed_variables.php');


echo '<ul>'.PHP_EOL;

foreach($nav_array_dynamic as $key => $value){

	if($value == $section){//if 'true' add custom class
		
		echo '<li id="'. $key .'"><a href="index.php?section=' . $value .'"class="selected">' . $value .'</a></li>'.PHP_EOL;
		
	}else{//if not true do not add custom class
		
		echo '<li id="'. $key .'"><a href="index.php?section=' . $value .'">'. $value .'</a></li>'.PHP_EOL;
		
	}

}

echo '</ul>'.PHP_EOL;









?>