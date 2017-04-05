 <?php
 function developmentMode($isDevelopment){
   if($isDevelopment == true) {
     // development link
     $clearSession = "logout.php";
   } else {
     // deployment link
     $clearSession = "logout.php";
   }
   return $clearSession;
 } 
?> 
 
 <?php
 function queryUserAccess($db, $isDevelopment){
   if($isDevelopment == true) {

     $data = array();
     $results = pg_query($db, "SELECT name, employee_username, employee_password FROM public.employee");
  
     if(!$db) {
       $msg = "An error occured.";
       exit;
     }  
     
     while($row = pg_fetch_row($results)) {
       $name = $row[0];
       $user = $row[1];
       $password = $row[2];
       $data[$user] = array($password, $name); 
     }

   } else {
     $query = "SELECT e_name, employee_username, employee_password"
          . " FROM employee";
     $result = $db->query($query);
     while($row = $result->fetch(PDO::FETCH_ASSOC)) {
       $data[$row["employee_username"]] = array($row["employee_password"], $row["e_name"]);
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
        $_SESSION['name'] = $result[1];;
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