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
		$query = "SELECT M.product, M.serial_number, M.inventory FROM merchandise as M, shop as S WHERE M.s_id = S.shop_id AND S.service_type = 'food';";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["product"], $row["serial_number"], $row["inventory"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
