<?php
$dsn = "pgsql:"
    . "host=ec2-50-17-236-15.compute-1.amazonaws.com;"
    . "dbname=d2641hluvfmus5;"
    . "user=nqxatreczgovme;"
    . "port=5432;"
    . "sslmode=require;"
    . "password=91ef1bd79a01039737b248bdc7a465b27b284af93a537cfd217a5135d94f95d8";

$db = new PDO($dsn);
  ob_start();
  session_start();
           
session_start();
require_once 'vendor/autoload.php';
?>
<?php
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
  'auto_reload' => true
));
?>
<?php
$template = $twig->load('index.html');
// development link
//$clearSession = "http://ta_code.dev/logout.php"
// deployment link
$clearSession = "https://theme-park-management.herokuapp.com/logout.php";

$username = 'tutorialspoint';
$password = '1234';
$msg = '';
      
  if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))  {
  
     // This is currently hard coded and needs to be changed to pull actual information from the database.
    
    if ($_POST['username'] == $username && $_POST['password'] == $password) {
      $_SESSION['valid'] = true;
      $_SESSION['timeout'] = time();
      $msg = 'You have entered a valid user name and password!';
    } else {
      $msg = 'Wrong username and password';
    }
  } else {
    $msg = 'Empty Username and Password';
  }
echo $template->render(array('msg' => $msg));

?>