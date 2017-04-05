<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$twig = loadEnvironment();
?>

<?php
	$loader = new Twig_Loader_Filesystem('templates');
	$twig = new Twig_Environment($loader, array('auto_reload' => true));
	$isDevelopment = false;
	$clearSession = developmentMode($isDevelopment);
	$db = loadDB($isDevelopment);
?>

<?php
	$template = $twig->load('merchandise.html');
    	$msg ='';
	echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
 ?>
