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
		$query = "SELECT M.s_id, M.product, M.serial_number, M.inventory, E.m_date, E.units_sold FROM merchandise AS M, merchandise_sales AS E, shop AS S WHERE S.service_type = 'food' AND M.s_id = S.shop_id;";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["s_id"], $row["product"], $row["serial_number"], $row["inventory"], $row["m_date"], $row["units_sold"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
