<?php
  include 'app/base.php';
  $twig = loadEnvironment();
  $loginLink = "https://theme-park-management.herokuapp.com/";
?>

<?php
  $template = $twig->load('menu.html');
  echo $template->render(array('login' => $loginLink)); 
?>
