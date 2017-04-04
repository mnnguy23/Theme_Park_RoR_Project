<?php
include 'app/base.php';
include 'app/indexFunctions.php';
$isDevelopment = false;
$twig = loadEnvironment();
$clearSession = developmentMode($isDevelopment);

  $loginLink = "http://ta_code.dev/index.php";
?>

<?php
  $user = $_SESSION['user'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  
  $template = $twig->load('menu.html');
  $params = array('logout' => $clearSession, 'user' => $user, 'fname' => $fname, 'lname' => $lname);
  echo $template->render($params);
?>