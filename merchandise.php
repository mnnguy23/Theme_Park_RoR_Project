<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$twig = loadEnvironment();
	$isDevelopment = false;
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$template = $twig->load('merchandise.html');
	$msg = inputMerchandise($dbConn, $isDevelopment);
	echo $template->render(array('msg' => $msg));
?>

<?php
	function inputMerchandise($db, $isDevelopment) {
		$uniqueInfos = gatherInfo($db, $isDevelopment);
  
		$msg = "All fields must be entered.";
		if(isset($_POST['submit'])) {
			$name = $_POST["name"];
     
			if(!checkDuplicateProductName($uniqueInfos)) {
				$product = $_POST["product"];
			} 
			else {
				$msg = "Duplicate Product Name found";
			}
			
			if(!checkSerialNumber($uniqueInfos)) {
				$serial_number = $_POST["serial_number"];
			} 
			else {
				$msg = "Duplicate Product Name found";
			}
		
			$inventory = $_POST["inventory"];
			$s_id = $_POST["s_id"];
     
			if(!checkDuplicateProductName($uniqueInfos) && !checkSerialNumber($uniqueInfos)){
				$query = "INSERT INTO merchandise VALUES ('$product', $serial_number, $inventory, $s_id);";
       
				if($isDevelopment) {
					$result = pg_query($db, $query);
				} 
				else {
					$result = $db->query($query);
				}
       
				if($result) {
					$msg = "Merchandise: $name was successfully created.";
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
				$data[] = array('product' => $row[0], 'serial_number' => $row[1], 'inventory' => $row[2], 's_id' => $row[3]);
			}
		} 
		else {
			$result = $db->query($query);
    
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$data[] = array('product' => $row['product'], 'serial_number' => $row['serial_number'], 'inventory' => $row["inventory"], "s_id" => $row["s_id"]);
			}
		}
  
		return $data;
	}
?>

<?php
	function checkDuplicateProductName($infos) {
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
	function checkSerialNumber($infos) {
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
