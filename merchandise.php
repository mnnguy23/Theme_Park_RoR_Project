<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$twig = loadEnvironment();
	$template = $twig->load('merchandise.html');
?>

<?php
	$isDevelopment = false;
	$db = loadDB($isDevelopment);
?>

<?php
	$template = $twig->load('merchandise.html');
    	$msg ='';
	echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
 ?>
