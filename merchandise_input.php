<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$twig = loadEnvironment();
	$isDevelopment = false;
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$shops = getShops($dbConn);
	$template = $twig->load('addMerchandise.html');
	$msg = inputMerchandise($dbConn, $isDevelopment);
	echo $template->render(array('shops' => $shops, 'msg' => $msg, 'dno'=>$_SESSION['dno']));
?>

<?php
	function inputMerchandise($db, $isDevelopment) {
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
			$serial_number = createSerialNumber($db, $isDevelopment);
			$s_id = array_search($_POST["s_id"], getShops($db));
     
			if(!checkDuplicateProduct($uniqueInfos)){
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
	function createSerialNumber($db, $isDevelopment) {
		$data = array();
		$currentSerialNumber = 0;
		$query = "SELECT serial_number FROM merchandise;";
		
		if($isDevelopment) {
			$results = pg_query($db, $query);
    
			while($row = pg_fetch_row($results)) {
    
				if($row[0] > $currentSerialNumber) {
					$currentSerialNumber = $row[0];
				}
			}
		} 
		else {
			$result = $db->query($query);
    
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
		
				if($row["serial_number"] > $currentSerialNumber) {
					$currentSerialNumber = $row["serial_number"];
				}
			}
		}
		$newSerialNumber = $currentSerialNumber + 1;
		return $newSerialNumber;
	}
?>

<?php
	function getShops($db) {
		$data = array();
		$query = "SELECT s_id, name FROM merchandise, shop WHERE s_id = shop_id;";
		$result = $db->query($query);
		
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$s_id = $row['s_id'];
			$name = trim($row['name']);
			$data[$s_id] = $name;
		}
		$result->closeCursor();
		return $data;
	}
?>
