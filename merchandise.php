<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$isDevelopment = false;
	$twig = loadEnvironment();
	$clearSession = developmentMode($isDevelopment);
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$foods = foodReport($dbConn);
	$gifts = giftReport($dbConn); 
	$template = $twig->load('merchandise.html');
	echo $template->render(array('foods' => $foods, 'gifts' => $gifts, 'logout' => $clearSession));
?>

<?php
	function foodReport($db) {
		$data = array();
		$query = "SELECT shop_id, product, name, serial_number, inventory FROM shop, merchandise WHERE shop_id = s_id AND service_type = 'food';";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["serial_number"], $row["product"], $row["name"], $row["inventory"]);
		}
		$result->closeCursor();
		return $data;
	}

	function giftReport($db) {
		$data = array();
		$query = "SELECT shop_id, product, name, serial_number, inventory FROM shop, merchandise WHERE shop_id = s_id AND service_type = 'gifts';";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["serial_number"], $row["product"], $row["name"], $row["inventory"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
