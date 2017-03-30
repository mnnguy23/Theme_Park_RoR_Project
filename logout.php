<?php
  session_start();
  $isDevelopment = false;
  require_once 'vendor/autoload.php';
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   unset($_SESSION["login"]);

   if ($isDevelopment) {
     // dev link
     $loginLink = "http://ta_code.dev/index.php";
   } else {
     // deployment link
     $loginLink = "https://theme-park-management.herokuapp.com/index.php";
   }
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
echo $template->render(array('msg' => $msg, 'login' => $loginLink));
?>