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
	$template = $twig->load('displayEmp.html');
	
	$query = "SELECT fname, lname, ssn, bdate, address, salary, dno, phone_number"
			"FROM employee";
	$result = $db->query($query);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array($row["fname"], $row["lname"], $row["snn"], $row["salary"]);
    }
	echo $template->render(array('msg' => $msg, 'clear' => $clearSession, 'empData' => $data));
?>