<?php
  include 'app/base.php';
  $twig = loadEnvironment();
  $loginLink = "http://ta_code.dev/index.php";
?>

<?php
  $template = $twig->load('menu.html');
  echo $template->render(array('login' => $loginLink)); 
?>
