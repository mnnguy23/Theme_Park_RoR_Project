<?php
	function deleteEmployee($db,$dno, $shops) {
		$msg = "Please select employee";
		
		if(isset($_POST['submit']) && isset($_POST['checkBox'])){
     
			$empName = $_POST["e_name"];
			$s_id = array_search($empName, $shops);
      			
     
			
				$query = "DELETE FROM employee WHERE employee_id=$s_id AND dno=$dno;";
       
					$result = $db->query($query);
		
				if($result) {
					$msg = "Employee: $empName was successfully removed.";
				}
		} else {
		  $msg = "Checkbox must also be selected to delete the Employee.";
		} 
		return $msg;
	}
?>

<?php
	function getEmployees($db,$dno) {
		$data = array();
		$query = "SELECT e.employee_id, e.e_name FROM employee AS e, department AS d WHERE e.employee_id != d.mgr_id AND e.dno=$dno AND d.dnumber=$dno;";		
		$result = $db->query($query);
		
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$empId = $row['employee_id'];
			$name = trim($row['e_name']);
			$data[$empId] = $name;
		}
		$result->closeCursor();
		return $data;
	}
?>
