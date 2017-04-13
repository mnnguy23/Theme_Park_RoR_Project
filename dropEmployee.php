<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$twig = loadEnvironment();
	$isDevelopment = false;
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$shops = getShops($dbConn);
	$template = $twig->load('deleteEmployee.html');
	$msg = inputMerchandise($dbConn, $isDevelopment);
  if(!$_SESSION['isManager']) {
    menuRedirect();
  }
  if($_SESSION['valid']){
    echo $template->render(array('employees' => $shops, 'msg' => $msg, 'dno'=>$_SESSION['dno']));  } else {
    loginRedirect();
  }
	
?>

<?php
	function inputMerchandise($db, $isDevelopment) {
		$msg = "Please select employee";
		
		if(isset($_POST['submit'])){
     
			
			$s_id = array_search($_POST["e_name"], getShops($db));
      $dno= $_SESSION['dno'];
     
			
				$query = "DELETE FROM employee WHERE employee_id=$s_id AND dno=$dno;";
       
				if($isDevelopment) {
					$result = pg_query($db, $query);
				} 
				else {
					$result = $db->query($query);
				}
		
				if($result) {
					$msg = "Employee: $s_id was successfully removed.";
				}
			
		} 
		return $msg;
	}
?>

<?php
	function getShops($db) {
		$data = array();
		$query = "SELECT employee_id, e_name,dno FROM employee;";
		$result = $db->query($query);
		
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$s_id = $row['employee_id'];
			$name = trim($row['e_name']);
			$data[$s_id] = $name;
		}
		$result->closeCursor();
		return $data;
	}
?>
