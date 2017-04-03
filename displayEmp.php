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
	echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
	
	$query = "SELECT fname, lname, ssn, bdate, addredd, sex, salary, super_ssn, dno, phone_number, employee_username, employee_password"
			"FROM employee";
	$result = $db->query($query);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["ride_id"] . "</td>";
    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
    echo "<td>" . $row["date_built"] . "</td>";
    echo "</tr>";
			 
?>