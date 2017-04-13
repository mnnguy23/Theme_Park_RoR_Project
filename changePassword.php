<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
  $twig = loadEnvironment();
  $isDevelopment = false;
  $dbConn = loadDB($isDevelopment);
?>

<?php
$template = $twig->load('changePassword.html');
$msg = inputEmployee($dbConn, $isDevelopment);
if(!$_SESSION['isManager']) {
  menuRedirect();
}
if($_SESSION['valid']){
  echo $template->render(array('msg' => $msg, 'dno' => $_SESSION['dno']));
} else {
  loginRedirect();
}
?>

<?php
function inputEmployee($db, $isDevelopment) {
     $oldpass = $_POST["old_password"];
     $newpass = $_POST["new_password"];
     $cpass = $_POST["confirm_password"];
  
  $msg = "All fields must be entered.";
   if(isset($_POST['submit'])) {
     $name = $_POST["attraction_name"];
     
     if(!checkDuplicatePassword($newpass, $cpass)) {
       $name = $_POST["old_password"];
	//$msg="Your password has been changed";     
     } else {
       $msg = "The passwords don't match name found";
     }
     
     $att_id = createAttractionID($db, $isDevelopment);
     
     //all inputs have been tested for correctnes with $msg	   
     
     if(!checkDuplicateAname($uniqueInfos) ){
       $query = "Update employee 
       set password $newpass 
       where employee_password = $oldpass;";
       
       if($isDevelopment) {
         $result = pg_query($db, $query);
       } else {
         $result = $db->query($query);
       }
       if($result) {
         $msg = "Change Password: $Your passord was changed.";
       }
     }
   }
     
   return $msg;
}
?>

<?php
function checkDuplicatePassword($newpass, $cpass) {
  $result = false;
    if($newpass == $cpass){
      $result = true;
    } 
  return $result;
}
?>
