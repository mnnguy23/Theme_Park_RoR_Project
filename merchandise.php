<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$isDevelopment = false;
	$twig = loadEnvironment();
	$clearSession = developmentMode($isDevelopment);
	$dbConn = loadDB($isDevelopment);
?>

<?php
	/*$foods = foodReport($dbConn);
	$gifts = giftReport($dbConn); 
	$template = $twig->load('merchandise.html');
	echo $template->render(array('foods' => $foods, 'gifts' => $gifts, 'logout' => $clearSession));*/
	
	$template = $twig->load('merchandise.html');
	$query = inputFoodDateQuery($isDevelopment);
	$query = inputGiftsDateQuery($isDevelopment);
	$reports = foodReport($dbConn);
	$reports = giftReport($dbConn);
	echo $template->render(array('foods' => $foods, 'gifts' => $gifts, 'logout' => $clearSession));
?>

<?php
	function foodReport($db) {
		$data = array();
		$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'food' AND serial_number = serial_num;";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["shop_id"], $row["product"], $row["name"], $row["serial_number"], $row["inventory"]);
		}
		$result->closeCursor();
		return $data;
	}

	function giftReport($db) {
		$data = array();
		$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'gifts' AND serial_number = serial_num;";
		$result = $db->query($query);
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data[] = array($row["shop_id"], $row["product"], $row["name"], $row["serial_number"], $row["inventory"]);
		}
		$result->closeCursor();
		return $data;
	}
	
	function inputFoodDateQuery() {
		if($isDevelopment) {
			$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'food' AND serial_number = serial_num;";
  
			if(isset($_POST['submit']) && !empty($_POST["startDatepicker"]) && !empty($_POST["endDatepicker"])) {
    
				if($_POST["startDatepicker"] < $_POST["endDatepicker"]) {
					$startDate = $_POST["startDatepicker"];
					$endDate = $_POST["endDatepicker"];
					$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'food' AND serial_number = serial_num between '$startDate' AND '$endDate';";
				}
			}
		} 
		
		else {
			$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'food' AND serial_number = serial_num;";
  
			if(isset($_POST['submit']) && !empty($_POST["startDatepicker"]) && !empty($_POST["endDatepicker"])) {
    
				if($_POST["startDatepicker"] < $_POST["endDatepicker"]) {
					$startDate = $_POST["startDatepicker"];
					$endDate = $_POST["endDatepicker"];
					$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'food' AND serial_number = serial_num between '$startDate' AND '$endDate';";
				}
			}
		}
		return $query;
	}
	
	function inputGiftsDateQuery() {
		if($isDevelopment) {
			$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'gifts' AND serial_number = serial_num;";
  
			if(isset($_POST['submit']) && !empty($_POST["startDatepicker"]) && !empty($_POST["endDatepicker"])) {
    
				if($_POST["startDatepicker"] < $_POST["endDatepicker"]) {
					$startDate = $_POST["startDatepicker"];
					$endDate = $_POST["endDatepicker"];
					$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'gifts' AND serial_number = serial_num between '$startDate' AND '$endDate';";
				}
			}
		} 
		
		else {
			$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'gifts' AND serial_number = serial_num;";
  
			if(isset($_POST['submit']) && !empty($_POST["startDatepicker"]) && !empty($_POST["endDatepicker"])) {
    
				if($_POST["startDatepicker"] < $_POST["endDatepicker"]) {
					$startDate = $_POST["startDatepicker"];
					$endDate = $_POST["endDatepicker"];
					$query = "SELECT shop_id, product, name, serial_number, inventory, units_sold, m_date FROM shop, merchandise, merchandise_sales WHERE shop_id = s_id AND service_type = 'gifts' AND serial_number = serial_num between '$startDate' AND '$endDate';";
				}
			}
		}
		return $query;
	}
?>
