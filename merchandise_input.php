<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$twig = loadEnvironment();
	$isDevelopment = false;
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$template = $twig->load('addMerchandise.html');
	$msg = inputEmployee($dbConn, $isDevelopment);
	echo $template->render(array('msg' => $msg));
?>

<?php
	function inputEmployee($db, $isDevelopment) {
		$uniqueInfos = gatherInfo($db, $isDevelopment);
		$msg = "All fields must be entered.";
		
		if(isset($_POST['submit'])) {
			if(!checkDuplicateProduct($uniqueInfos)) {
				$product = $_POST["product"];
			} 
			else {
				$msg = "Duplicate Product Name found";
			}
     
			$inventory = $_POST["inventory"];
			
			if(!checkDuplicateSerialNumber($uniqueInfos)) {
				$serial_number = $_POST["serial_number"];
			} 
			else {
				$msg = "Duplicate Serial Number Found";
			}
			
			$s_id = $_POST["s_id"];
     
			if(!checkDuplicateProduct($uniqueInfos) && !checkDuplicateSerialNumber($uniqueInfos)){
				$query = "INSERT INTO merchandise VALUES ('$product', $inventory, $serial_number, $s_id);";
       
				if($isDevelopment) {
					$result = pg_query($db, $query);
				} 
				else {
					$result = $db->query($query);
				}
		
				if($result) {
					$msg = "Merchandise: $product was successfully created.";
				}
			}
		} 
		return $msg;
	}
?>

<?php
	function gatherInfo($db, $isDevelopment) {
		$query = "SELECT * FROM merchandise;";
		$data = array();
  
		if($isDevelopment) {
			$result = pg_query($db, $query);
    
			while($row = pg_fetch_row($result)) {
				$data[] = array('product' => $row[0], 'inventory' => $row[1], 'serial_number' => $row[2], 's_id' => $row[3]);
			}
		} 
		else {
			$result = $db->query($query);
    
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$data[] = array('product' => $row['product'], 'inventory' => $row['inventory'], 'serial_number' => $row["serial_number"], "s_id" => $row["s_id"]);
			}
		}
		return $data;
	}
?>

<?php
	function checkDuplicateProduct($infos) {
		$result = false;

		foreach($infos as $info) {
			$product = $info['product'] ?? null;
    
			if($product == $_POST["product"]){
				$result = true;
			} 
		}
		return $result;
	}
?>

<?php
	function checkDuplicateSerialNumber($infos) {
		$result = false;

		foreach($infos as $info) {
			$serial_number = $info['serial_number'] ?? null;
    
			if($serial_number == $_POST["serial_number"]){
				$result = true;
			} 
		}
		return $result;
	}
?>