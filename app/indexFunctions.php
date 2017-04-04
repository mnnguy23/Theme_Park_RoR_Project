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
   $data = array();
   
   if($isDevelopment == true) {
     $results = pg_query($db, "SELECT fname, lname, employee_username, employee_password FROM public.employee");
  
     if(!$db) {
       $msg = "An error occured.";
       exit;
     }  
     
     while($row = pg_fetch_row($results)) {
       $fname = $row[0];
       $lname = $row[1];
       $user = $row[2];
       $password = $row[3];
       $data[$user] = array($password, $fname, $lname); 
     }

   } else {
     
     $query = "SELECT fname, lname, employee_username, employee_password"
          . " FROM employee";
     $result = $db->query($query);
     
     while($row = $result->fetch(PDO::FETCH_ASSOC)) {
       $fname = $row['fname'];
       $lname = $row['lname'];
       $user = $row['employee_username'];
       $password = $row['employee_password'];
       $data[$user] = array($password, $fname, $lname);
     }
     $result->closeCursor();

   }
   return $data;
 }
 ?>

<?php
  function checkCredential($data){
    if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password']))  {
      
      $result = $data[$_POST['username']] ?? null;
      $username = NULL;
      $password = NULL;
      if($result != null) {
        $username = $_POST['username'];
        $password = $result[0];
      }
   
      if ($_POST['username'] == $username && $_POST['password'] == $password) {
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['user'] = $username;
        $_SESSION['fname'] = $result[1];
        $_SESSION['lname'] = $result[2];
        $info = 'Valid username and password';
      } else {
        $_SESSION['valid'] = false;
        $info = 'Wrong username and/or password';
        unset($_SESSION["username"]);
        unset($_SESSION["password"]);
        unset($_SESSION["login"]);
      }
    } else {
      $info = '';
    }
    return array($_SESSION['valid'], $info);
  }
?>

<?php
function menuRedirect() {
  header('Location: menu.php');
}
?>