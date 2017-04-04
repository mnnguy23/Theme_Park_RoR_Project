<?php
include 'app/base.php';
$twig = loadEnvironment();
   $isDevelopment = false;
   $login = loginLink($isDevelopment);
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

<?php
function loginLink($isDevelopment) {
  if ($isDevelopment) {
    // dev link
    $link = "http://ta_code.dev/index.php";
  } else {
    // deployment link
    $link = "https://theme-park-management.herokuapp.com/index.php";
  }
  return $link;
}
?>