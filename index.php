<?php
  ob_start();
  session_start();
           
?>

<?
  // error_reporting(E_ALL);
  // ini_set("display_errors", 1);
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
  <head>
    <title>Log In Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    
    <link href="css/main.css" rel="stylesheet">
          
  </head>
  <body>
    <h1>Theme Park Management Portal</h1>
    <h2>Enter Username and Password</h2>
    <div class = "container form-signin">
      <?php
        $msg = '';
      
        if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
        
          // This is currently hard coded and needs to be changed to pull actual information from the database.
          
          if ($_POST['username'] == 'tutorialspoint' && $_POST['password'] == '1234') {
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            $_SESSION['username'] = 'tutorialspoint';        
            echo 'You have entered a valid user name and password!';
          } else {
            $msg = 'Wrong username and password';
          }
        }
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
