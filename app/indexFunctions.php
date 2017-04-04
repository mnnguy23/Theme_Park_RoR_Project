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

     $data = array();
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
       $data[$row["employee_username"]] = array($row["employee_password"], $row["fname"], $row["lname"]);
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
      echo $result;
      $username = NULL;
      $password = NULL;
      if($result != null) {
        $username = $_POST['username'];
        $password = $result[0];
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
      $msg = '';
    }
    return $msg;
  }
?>

<?php
function menuRedirect() {
  header('Location: menu.php');
}
?>