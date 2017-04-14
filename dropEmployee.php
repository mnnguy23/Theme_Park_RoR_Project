<?php
	function deleteEmployee($db,$dno, $shops) {
		$msg = "Please select employee";
		
		if(isset($_POST['submit'])){
     
			
			$s_id = array_search($_POST["e_name"], $shops);
      			
     
			
				$query = "DELETE FROM employee WHERE employee_id=$s_id AND dno=$dno;";
       
					$result = $db->query($query);
		
				if($result) {
					$msg = "Employee: $s_id was successfully removed.";
				}
			
		} 
		return $msg;
	}
?>

<?php
	function getEmployees($db,$dno) {
		$data = array();
		$query = "SELECT e.employee_id, e.e_name,e.dno FROM employee AS e, department AS d WHERE e.employee_id<>d.mgr_id AND e.dno=$dno;";		
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
