<?php
	include 'app/base.php';
	$isDevelopment = false;
	$twig = loadEnvironment();
	$clearSession = developmentMode($isDevelopment);
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$merchandises = merchandiseReport($dbConn); 
	$template = $twig->load('merchandise.html');
	echo $template->render(array('merchandises' => $merchandises));
?>

<?php
	function merchandiseReport($db) {
		$data = array();
		$query = "SELECT M.product, M.inventory, M.serial_number, M.s_id FROM merchandise as M;";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["product"], $row["inventory"], $row["serial_number"], $row["s_id"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
