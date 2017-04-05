<?php
	session_start();
	$dsn = "pgsql:"
    . "host=ec2-50-17-236-15.compute-1.amazonaws.com;"
    . "dbname=d2641hluvfmus5;"
    . "user=nqxatreczgovme;"
    . "port=5432;"
    . "sslmode=require;"
    . "password=91ef1bd79a01039737b248bdc7a465b27b284af93a537cfd217a5135d94f95d8";
	$db = new PDO($dsn);
	ob_start();
	session_start();           
?>

<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
	$twig = loadEnvironment();
?>

<?php
	$loader = new Twig_Loader_Filesystem('templates');
	$twig = new Twig_Environment($loader, array('auto_reload' => true));
	$isDevelopment = false;
	$clearSession = developmentMode($isDevelopment);
	$db = loadDB($isDevelopment);
?>

<?php
	$template = $twig->load('merchandise.html');
	$query = "SELECT product, inventory, sold, units_sold_weekly, serial_number, merchandise_serial_number_key, max_inventory"
			"FROM merchandise";
	$result = $db->query($query);
	while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
		$data[] = array($row["product"], $row["inventory"], $row["sold"], $row["units_sold_weekly"], $row["serial_number"]);
    }
    $msg ='';
	echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
 ?>
