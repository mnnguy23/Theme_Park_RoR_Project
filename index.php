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
  list($users, $passwords) = queryUserAccess($dbConn, $isDevelopment);
  $msg = checkCredential($users, $passwords);
  echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
?>

<?php
  function pg_list_tables($dbConn) {
    $sql = "select relname from pg_stat_user_tables order by relname;";
    return pg_query($dbConn, $sql);
  }
?>
