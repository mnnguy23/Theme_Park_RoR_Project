<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$isDevelopment = false;
	$twig = loadEnvironment();
	$clearSession = developmentMode($isDevelopment);
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$gifts = giftReport($dbConn); 
	$template = $twig->load('merchandise.html');
	echo $template->render(array('gifts' => $gifts, 'logout' => $clearSession));
?>

<?php
	function giftReport($db) {
		$data = array();
		$query = "SELECT shop_id, product, serial_number, inventory, units_sold FROM shop, merchandise WHERE shop_id = s_id AND service_type = 'gifts';";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["shop_id"], $row["product"], $row["serial_number"], $row["inventory"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
