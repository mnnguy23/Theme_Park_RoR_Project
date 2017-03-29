<?php
<<<<<<< HEAD
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
           
=======
session_start();
require_once 'vendor/autoload.php';
>>>>>>> login-page
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
<<<<<<< HEAD
      ?>
    </div>
    
    <div class = "container">
      <form class ="form-signin" role = "form"
        action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);
        ?>" method = "post">
        <h4 class="form-signin-heading"><?php echo $msg; ?></h4>
        <input type="text" class = "form-control"
          name = "username" placeholder="Enter your username"
          required autofocus>
        </br>
        <label for="password" class="sr-only">Password</label>
        <input type="password" class="form-control"
          name="password" placeholder="enter your password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit"
          name="login">Login</button>
      </form>
    </div>
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  </body>
</html>
=======
echo $template->render(array('msg' => $msg));

?>
>>>>>>> login-page
