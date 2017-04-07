<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$isDevelopment = false;
	$twig = loadEnvironment();
	$clearSession = developmentMode($isDevelopment);
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$merchandises = merchandiseReport($dbConn); 
	$template = $twig->load('merchandise.html');
	echo $template->render(array('merchandises' => $merchandises, 'logout' => $clearSession));
?>

<?php
	function merchandiseReport($db) {
		$data = array();
		$query = "SELECT shop_id, product, serial_number, inventory FROM shop, merchandise WHERE service_type = 'food' AND shop_id = s_id;";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["shop_id"], $row["product"], $row["serial_number"], $row["inventory"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
