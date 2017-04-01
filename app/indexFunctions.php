 <?php
 function developmentMode($isDevelopment){
   if($isDevelopment == true) {
     // development link
     $clearSession = "logout.php";
   } else {
     // deployment link
     $clearSession = "https://theme-park-management.herokuapp.com/logout.php";
   }
   return $clearSession;
 } 
?> 
 
 <?php
 function queryUserAccess($db, $isDevelopment){
   if($isDevelopment == true) {
     $users = array();
     $passwords = array();
     $results = pg_query($db, "SELECT employee_username, employee_password FROM public.employee");
  
     if(!$db) {
       $msg = "An error occured.";
       exit;
     }
  
     while($row = pg_fetch_row($results)) {
       $users[] = $row[0];
       $passwords[] = $row[1];
     }
   } else {
     $query = "SELECT employee_username, employee_password"
          . "FROM employee";
     $result = $db->query($query);
     while($row = $result->fetch(PDO::FETCH_ASSOC)) {
       $user[] = $row["employee_username"];
       $passwords[] = $row["employee_password"];
     }
   }
   return array($users, $passwords);
 }
 ?>
<?php
  function checkCredential($usernames, $passwords){
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))  {
      
      list($result, $index) = findUser($usernames);
      $username = NULL;
      $password = NULL;
      if($result) {
        $username = $usernames[$index];
        $password = $passwords[$index];
      }
   
      if ($_POST['username'] == $username && $_POST['password'] == $password) {
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $msg = 'You have entered a valid user name and password!';
        menuRedirect();
      } else {
        $msg = 'Wrong username and password';
        unset($_SESSION["username"]);
        unset($_SESSION["password"]);
        unset($_SESSION["login"]);
      }
    } else {
      $msg = 'Enter Username and Password';
    }
    return $msg;
  }
?>

<?php
function findUser($usernames) {
  $userFound = false;
  $index = 0;
  while($index < sizeof($usernames) && !$userFound) {
    if($_POST['username'] == $usernames[$index]) {
      $userFound = true;
    } else {
      $index++;
    }
  }
  return array($userFound, $index);
}
?>

<?php
function menuRedirect() {
  header('Location: menu.php');
}
?>