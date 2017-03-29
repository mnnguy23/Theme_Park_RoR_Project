<?php
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