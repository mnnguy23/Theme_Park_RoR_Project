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
		$query = "SELECT s_id, product, serial_number, inventory, m_date, units_sold FROM merchandise, merchandise_sales, shop WHERE service_type = 'food' AND s_id = shop_id;";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["s_id"], $row["product"], $row["serial_number"], $row["inventory"], $row["m_date"], $row["units_sold"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
