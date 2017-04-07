<?php
include 'app/base.php';
$twig = loadEnvironment();
   $login = 'index.php';
?>

<?php
$_SESSION['valid'] = false;
unset($_SESSION["username"]);
unset($_SESSION["password"]);
unset($_SESSION["login"]);
$template = $twig->load('logout.html');
$msg = 'You have logged out.';
echo $template->render(array('msg' => $msg, 'login' => $login));
?>