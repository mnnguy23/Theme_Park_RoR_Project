<?php
session_start();
require_once 'vendor/autoload.php';
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["login"]);
?>
<?php
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
 'auto_reload' => true
));
?>

<?php
$template = $twig->load('logout.html');
$msg = 'You have cleaned session';

// dev link
//$loginLink = "http://ta_code.dev/index.php";

// deployment link
$loginLink = "https://theme-park-management.herokuapp.com/index.php"
echo $template->render(array('msg' => $msg, 'link' => $loginLink));
?>