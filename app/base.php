<?php
function loadEnvironment() {
  session_start();
  require_once 'vendor/autoload.php';
  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader, array(
    'auto_reload' => true
  ));
  return $twig;
}
?>

<?php
function loadDB($isDevelopment) {
  if($isDevelopment) {
    $host = "localhost";
    $port = "5432";
    $dbname = "theme_park";
    $user = "tester";
    $password = "1234";
    $db = new PDO("pgsql: host=$host port=$port dbname=$dbname user=$user password=$password");
  } else {
    $dsn = "pgsql:"
        . "host=ec2-50-17-236-15.compute-1.amazonaws.com;"
        . "dbname=d2641hluvfmus5;"
        . "user=nqxatreczgovme;"
        . "port=5432;"
        . "sslmode=require;"
        . "password=91ef1bd79a01039737b248bdc7a465b27b284af93a537cfd217a5135d94f95d8";
    $db = new PDO($dsn);
  }
  return $db;
}
?>
<?php
function loginRedirect() {
  header('Location: index.php');
}
?>