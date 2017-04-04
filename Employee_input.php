<?php/*
	
    $conn= pg_connect("host=localhost dbname=postgres user=postgres password=warrior12");
   if(! $conn ) {
      die('Could not connect: ' . pg_error());
   }
   
   echo 'Connected successfully';
   pg_close($conn);
*/?>

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
  //$dbConn = loadDB($isDevelopment);
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
    if(empty($_POST['email'])){
        // Adds name to array
        $data_missing[] = 'Email';
    } else {
        // Trim white space from the name and store the name
        $email = trim($_POST['email']);
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
        // Adds name to array
        $data_missing[] = 'Supervisor';
    } else {
        // Trim white space from the name and store the name
        $Supervisor = trim($_POST['Supervisor']);
    }
	if(empty($_POST['Manages'])){
        // Adds name to array
         $data_missing[] = 'Manages';
    } else {
        // Trim white space from the name and store the name
        $Manages = trim($_POST['Manages']);
    }
    
    if(empty($data_missing)){
        
        //require_once('../mysqli_connect.php');// needs to deal with .....whatever my db my local db is on
        
        $query = "INSERT INTO Employees(fname,lname,StartDate,email,ssn,bdate,address,sex,salary,super_ssn,phone_number) VALUES 
	($first_name, $last_name,$Start_Date, $email,
        $ssn, $birth_date, $address, $sex,
        $salary,$supervisor,$phone)";// needs editing
        
        //$stmt = mysqli_prepare($dbConn, $query);
	
	
	    
	    
        $result = pg_query($dbconn,$query); 
	if (!$result) { 
    		$errormessage = pg_last_error(); 
   		echo "Error with query: " . $errormessage; 
    		exit(); 
	} 

  	pg_close();
        
    } else {
        
        echo 'You need to enter the following data<br />';
        
        foreach($data_missing as $missing){
            
            echo "$missing<br />";
            
        }
        
    }
    
}
  
  //echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
  ?>
