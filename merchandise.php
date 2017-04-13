<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$isDevelopment = false;
	$twig = loadEnvironment();
	$dbConn = loadDB($isDevelopment);
?>

<?php
	$foods = foodReport($dbConn);
	$gifts = giftReport($dbConn); 
	$template = $twig->load('merchandise.html');
	
  if(!$_SESSION['isManager']) {
    menuRedirect();
  }
  if($_SESSION['valid']){
    echo $template->render(array('foods' => $foods, 'gifts' => $gifts, 'dno' => $_SESSION['dno']));
  } else {
    loginRedirect();
  }
?>

<?php
	function foodReport($db) {
		$data = array();
		$query = "SELECT shop_id, product, name, inventory FROM shop, merchandise WHERE shop_id = s_id AND service_type = 'food';";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["product"], $row["name"], $row["inventory"]);
		}
		$result->closeCursor();
		return $data;
	}

	function giftReport($db) {
		$data = array();
		$query = "SELECT shop_id, product, name, inventory FROM shop, merchandise WHERE shop_id = s_id AND service_type = 'gifts';";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["product"], $row["name"], $row["inventory"]);
		}
		$result->closeCursor();
		return $data;
	}
?>
