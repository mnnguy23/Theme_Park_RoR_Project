<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
?>
<?php
  session_start();
  require_once 'vendor/autoload.php';
  $isDevelopment = false;
  if($isDevelopment == true) {
    // development link
    $clearSession = "http://ta_code.dev/logout.php";
  } else {
    // deployment link
    $clearSession = "https://theme-park-management.herokuapp.com/logout.php";
  }
?>
<?php
  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader, array(
    'auto_reload' => true
  ));
  $isDevelopment = false;
  $clearSession = developmentMode($isDevelopment);
?>

<?php
$template = $twig->load('addEmployee.html');
  
  if(isset($_POST['submit'])){
    
    $data_missing = array();
    
    if(empty($_POST['first_name'])){
        // Adds name to array
        $data_missing[] = 'First Name';
    } else {
        // Trim white space from the name and store the name
        $f_name = trim($_POST['first_name']);
    }
    if(empty($_POST['last_name'])){
        // Adds name to array
        $data_missing[] = 'Last Name';
    } else{
        // Trim white space from the name and store the name
        $l_name = trim($_POST['last_name']);
    }
    if(empty($_POST['address'])){
        // Adds name to array
        $data_missing[] = 'address';
    } else {
        // Trim white space from the name and store the name
        $address = trim($_POST['address']);
    }
    
    if(empty($_POST['phone'])){
        // Adds name to array
        $data_missing[] = 'Phone Number';
    } else {
        // Trim white space from the name and store the name
        $phone = trim($_POST['phone']);
    }
    if(empty($_POST['birth_date'])){
        // Adds name to array
        $data_missing[] = 'Birth Date';
    } else {
        // Trim white space from the name and store the name
        $b_date = trim($_POST['birth_date']);
    }
    if(empty($_POST['sex'])){
        // Adds name to array
        $data_missing[] = 'Sex';
    } else {
        // Trim white space from the name and store the name
        $sex = trim($_POST['sex']);
    }
    if(empty($_POST['SSN'])){
        // Adds name to array
        $data_missing[] = 'SSN';
    } else {
        // Trim white space from the name and store the name
        $SSN = trim($_POST['SSN']);
    }
	if(empty($_POST['Wage'])){
        // Adds name to array
        $data_missing[] = 'Wage';
    } else {
        // Trim white space from the name and store the name
        $Wage = trim($_POST['Wage']);
    }
	
	if(empty($_POST['Start_Date'])){
        // Adds name to array
        $data_missing[] = 'Start_Date';
    } else {
        // Trim white space from the name and store the name
        $Start_Date = trim($_POST['Start_Date']);
    }
	if(empty($_POST['Employee_ID'])){
        // Adds name to array
        $data_missing[] = 'Employee_ID';
    } else {
        // Trim white space from the name and store the name
        $Employee_ID = trim($_POST['Employee_ID']);
    }
	
	if(empty($_POST['Supervisor'])){
        	$Supervisor=NULL;
    } else {
        // Trim white space from the name and store the name
        $Supervisor = trim($_POST['Supervisor']);
    }
	if(empty($_POST['Manages'])){
        // Adds name to array
        // $data_missing[] = 'Manages';
		$Manages=NULL;;
    } else {
        // Trim white space from the name and store the name
        $Manages = trim($_POST['Manages']);
    }
    
    if(empty($data_missing)){
	$dbConn = loadDB($isDevelopment);
        $e_name=$f_name.' '.$l_name;
	$username=$l_name.$f_name;
	$password="password";
        
        $query = "INSERT INTO employee (e_name, ssn, employee_id, super_ssn, bdate, startdate, address, sex, salary, dno, phone_number, employee_username, employee_password) VALUES 
	($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13)";// needs editing
       	
	
	    
	$result = pg_query_params($dbConn,$query,array($e_name,$SSN, $Employee_ID, $Supervisor, $b_date, $Start_Date, $address, $sex,$Wage,$Manages,$phone,$username,$password));
	if (!$result) { 
   		echo "Error with query: " . $errormessage; 
    		exit(); 
	} 
	    //var_dump($dbConn);
  	 $result->$closeCursor();
	 
        
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}
echo 'Employee Added';
$msg= '';
echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
?>

