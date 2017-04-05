<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$isDevelopment = false;
	$twig = loadEnvironment();
	$clearSession = developmentMode($isDevelopment);
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$user = $_SESSION['user'];
	$name = $_SESSION['name'];
	$merchandise = merchandiseReport($dbConn, $isDevelopment); 
	$template = $twig->load('merchandise.html');
?>

<?php
	function merchandiseReport($db, $isDevelopment) {
		$data = array();
		if($isDevelopment) {
			$results = pg_query($db ,"SELECT M.product, M.inventory, M.sold, M.units_sold_weekly, M.serial_number, M.s_id FROM merchandise as M;");
			while($row = pg_fetch_row($results)) {
				$productName = $row[0];
				$inventory = $row[1];
				$sold = $row[2];
				$units_sold_weekly = $row[3];
				$serial_number = $row[4];
				$s_id = $row[5];
				$data[] = array($productName, $inventory, $sold, $units_sold_weekly, $serial_number, $s_id);
			}
		} 
		else {
			$query = "SELECT M.product, M.inventory, M.sold, M.units_sold_weekly, M.serial_number, M.s_id FROM merchandise as M;";
			$result = $db->query($query);
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				$data[] = array($row["product"], $row["inventory"], $row["sold"],$row["units_sold_weekly"], $row["serial_number"], $row[s_id], $isOperational);
			}
			$result->closeCursor();
		}  
		return $data;
	}
?>
