<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$twig = loadEnvironment();
	$isDevelopment = false;
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$template = $twig->load('changePassword.html');
	$msg = changePassword($dbConn, $isDevelopment);
	$name = $_SESSION['name'];

	if(!$_SESSION['isManager']) {
		menuRedirect();
	}
	
	if($_SESSION['valid']){
		echo $template->render(array('name' => $name, 'msg' => $msg, 'dno' => $_SESSION['dno']));
	} 
	else {
		loginRedirect();
	}
?>

<?php
	function changePassword($db, $isDevelopment) {
		$uniqueInfos = gatherInfo($db, $isDevelopment);
		$msg = "All fields must be entered.";

		if(isset($_POST['submit'])) {
			/*$oldPassword = $_POST["old_password"];
			$newPassword = $_POST["new_password"];
			$confirmPassword = $_POST["confirm_password"];*/
			
			if(checkOriginalPassword($uniqueInfos)) {
				$oldPassword = $_POST["old_password"];  
			} 
			else {
				$msg = "Wrong original password entered.";
			}  
     
			if(!checkDuplicatePassword()) {
				$newPassword = $_POST["new_password"];  
			} 
			else {
				$msg = "Can't create same password.";
			}  
			
			if(checkNewPassword()) {
				$confirmPassword = $_POST["confirm_password"];  
			} 
			else {
				$msg = "New and Confirm passwords are not the same.";
			}
     
			if(checkOriginalPassword($uniqueInfos) && !checkDuplicatePassword() && checkNewPassword()){
				$query = "UPDATE employee SET employee_password = '$newPassword' WHERE e_name = '$name';";
       
				if($isDevelopment) {
					$result = pg_query($db, $query);
				} 
				else {
					$result = $db->query($query);
				}
		
				if($result) {
					$msg = "Password had been changed.";
				}
			}
		}
		return $msg;
	}
?>

<?php
	function gatherInfo($db, $isDevelopment) {
		$query = "SELECT e_name, employee_password FROM employee;";
		$data = array();
  
		if($isDevelopment) {
			$result = pg_query($db, $query);
    
			while($row = pg_fetch_row($result)) {
				$data[] = array('e_name' => $row[0], 'employee_password' => $row[1]);
			}
		} 
		else {
			$result = $db->query($query);
    
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$data[] = array('e_name' => $row['e_name'], 'employee_password' => $row['employee_password']);
			}
		}
		return $data;
	}
?>

<?php
	function checkOriginalPassword($infos) {
		$result = false;
		foreach($infos as $info) {
			$password = $info['employee_password'] ?? null;
    
			if($password == $_POST["old_password"]){
				$result = true;
			} 
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
