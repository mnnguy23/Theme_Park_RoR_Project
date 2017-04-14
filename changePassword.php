<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	include 'employeeLink.php';
	$twig = loadEnvironment();
	$isDevelopment = false;
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$template = $twig->load('changePassword.html');
  $original = getPassword($dbConn);
	$msg = changePassword($dbConn, $original);
  $isManager = $_SESSION["isManager"];
	if($_SESSION['valid']){
		echo $template->render(array('msg' => $msg, 'dno' => $_SESSION['dno']), 'isManager'=>$isManager);
	} 
	else {
		loginRedirect();
	}
?>

<?php
	function changePassword($db, $originalPassword) {
		$msg = "All fields must be entered.";
		$empId = $_SESSION['emp_id'];

		if(isset($_POST['submit'])) {
     
      if(!checkOriginalPassword($originalPassword)) {
        $msg = "Type the old password correctly";
      }
      if(checkDuplicatePassword()) {
        $msg = "Your new password cannot be the new one.";
      }
      if(!checkNewPassword()) {
        $msg = "The passwords don't match.";
      }
      
			if(checkOriginalPassword($originalPassword) && !checkDuplicatePassword() && checkNewPassword()){
        $newPassword = $_POST["new_password"];
				$query = "UPDATE employee SET employee_password = '$newPassword' WHERE employee_id = $empId;";
       
				$result = $db->query($query);
          		
				if($result) {
					$msg = "Password had been changed.";
				}
        $result->closeCursor();
			}
		}
		return $msg;
	}
?>

<?php
	function getPassword($db) {
		$empId = $_SESSION['emp_id'];
		$query = "SELECT employee_password FROM employee WHERE employee_id = $empId;";
		$data = null;
		$result = $db->query($query);
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$data = trim($row['employee_password']);
			}
		return $data;
	}
?>

<?php
	function checkOriginalPassword($originalPassword) {
		$result = false;
		if($originalPassword == $_POST["old_password"]){
			$result = true;
		} 
		return $result;
	}
?>

<?php
	function checkDuplicatePassword() {
		$result = false;
    
		if($_POST["old_password"] == $_POST["new_password"]){
			$result = true;
		} 
		return $result;
	}
?>

<?php
	function checkNewPassword() {
		$result = false;
    
		if($_POST["new_password"] == $_POST["confirm_password"]){
			$result = true;
		} 
		return $result;
	}
?>
