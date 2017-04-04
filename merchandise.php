<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$isDevelopment = false;
	$twig = loadEnvironment();
	$clearSession = developmentMode($isDevelopment);
	$db = loadDB($isDevelopment);
	$loginLink = "http://ta_code.dev/index.php";
?>	
	
<?php
	$template = $twig->load('merchandise.html');
	echo $template->render(array('login' => $clearSession)); 
?>
