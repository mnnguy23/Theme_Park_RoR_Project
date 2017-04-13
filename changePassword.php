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

	if(!$_SESSION['isManager']) {
		menuRedirect();
	}
	
	if($_SESSION['valid']){
		echo $template->render(array('msg' => $msg, 'dno' => $_SESSION['dno']));
	} 
	else {
		loginRedirect();
	}
?>

<?php
	function changePassword($db, $isDevelopment) {
		$oldPassword = $_POST["old_password"];
		$newPassword = $_POST["new_password"];
		$confirmPassword = $_POST["confirm_password"];
		$msg = "All fields must be entered.";

		if(isset($_POST['submit'])) {
			$name = $_POST["attraction_name"];
     
			if(!checkDuplicatePassword($newPassword, $confirmPassword)) {
				$name = $_POST["old_password"];  
			} 
			else {
				$msg = "Wrong password";
			}  
     
			if(!checkDuplicateAname($uniqueInfos) ){
				$query = "UPDATE employee SET password = $newPassword WHERE employee_password = $oldPassword;";
       
				if($isDevelopment) {
					$result = pg_query($db, $query);
				} 
				else {
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
	function checkDuplicatePassword($newPassword, $confirmPassword) {
		$result = false;
    
		if($newPassword == $confirmPassword){
			$result = true;
		} 
		return $result;
	}
?>
