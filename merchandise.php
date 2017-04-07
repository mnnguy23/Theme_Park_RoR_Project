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
		$query = "SELECT M.s_id, M.product, M.serial_number, M.inventory FROM merchandise as M;";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["s_id"], $row["product"], $row["inventory"], $row["serial_number"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
