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
  $results = pg_query($dbConn, "SELECT employee_username, employee_password FROM public.employee");
  
  if(!$dbConn) {
    $msg = "An error occured.";
    exit;
  }
  
  $users = array();
  $passwords = array();
  
  while($row = pg_fetch_row($results)) {
    $users[] = $row[0];
    $passwords[] = $row[1];
  }
  $msg = checkCredential($users, $passwords);
  echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
?>

<?php
function pg_list_tables($dbConn) {
  $sql = "select relname from pg_stat_user_tables order by relname;";
  return pg_query($dbConn, $sql);
}
?>