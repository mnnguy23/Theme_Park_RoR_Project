<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$isDevelopment = false;
	$twig = loadEnvironment();
	$clearSession = developmentMode($isDevelopment);
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$foods = foodsReport($dbConn); 
	$gifts = giftsReport($dbConn);
	$template = $twig->load('merchandise.html');
	echo $template->render(array('foods' => $foods, 'gifts' => $gifts, 'logout' => $clearSession));
?>

<?php
	function foodsReport($db) {
		$data = array();
		$query = "SELECT M.s_id, M.product, M.serial_number, M.inventory, E.m_date, E.units_sold FROM merchandise as M, merchandise_sales as E, shop as S WHERE S.service_type = 'food', M.s_id = S.shop_id;";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["s_id"], $row["product"], $row["serial_number"], $row["inventory"], $row["m_date"], $row["units_sold"]);
		}
		$result->closeCursor();
		return $data;
	}
	
	function giftsReport($db) {
		$data = array();
		$query = "SELECT M.s_id, M.product, M.serial_number, M.inventory, E.m_date, E.units_sold FROM merchandise as M, merchandise_sales as E, shop as S WHERE S.service_type = 'gifts', M.s_id = S.shop_id;";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["s_id"], $row["product"], $row["serial_number"], $row["inventory"], $row["m_date"], $row["units_sold"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
