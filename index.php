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
  $data = queryUserAccess($dbConn, $isDevelopment);
  list($valid, $result) = checkCredential($data);
  
  echo $template->render(array('msg' => $result, 'clear' => $clearSession));
    if($valid) {
      menuRedirect();
    }
?>

<?php
function pg_list_tables($dbConn) {
  $sql = "select relname from pg_stat_user_tables order by relname;";
  return pg_query($dbConn, $sql);
}
?>