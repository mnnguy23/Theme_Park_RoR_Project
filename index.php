<?php  
  include 'app/base.php';
  include 'app/indexFunctions.php';
  $twig = loadEnvironment();
  $isDevelopment = false;
  $clearSession = developmentMode($isDevelopment);
  $dbConn = loadDB($isDevelopment);
?>

<?php
  $template = $twig->load('index.html');
  //$data = queryUserAccess($dbConn, $isDevelopment);
  //list($valid, $result) = checkCredential($data);
  
  echo $template->render(array('msg' => $result, 'clear' => $clearSession));
  /*
    if($valid) {
      menuRedirect();
    }
  */
?>