<?php
	include 'app/base.php';
	include 'app/indexFunctions.php';
  $twig = loadEnvironment();
  $isDevelopment = false;
  $dbConn = loadDB($isDevelopment);
?>

<?php
$template = $twig->load('addEmployee.html');

$msg = inputEmployee($dbConn, $isDevelopment);
echo $template->render(array('msg' => $msg));
?>

<?php
function inputEmployee($db, $isDevelopment) {
  $uniqueInfos = gatherInfo($db, $isDevelopment);
  
  $msg = "All fields must be entered.";
   if(isset($_POST['submit'])) {
     $name = $_POST["name"];
     
     if(!checkDuplicateSsn($uniqueInfos)) {
       $ssn = $_POST["SSN"];
     } else {
       $msg = "Duplicate SSN found";
     }
     if(!checkDuplicateUsername($uniqueInfos)) {
       $username = $_POST["username"];
     } else {
       $msg = "Duplicate username found";
     }
     
     if(!checkDuplicatePassword($uniqueInfos)) {
       $password = $_POST["password"];
     } else {
       $msg = "Duplicate Password Found";
     }
     
     if(!checkDuplicatePhoneNumber($uniqueInfos)) {
       $phoneNumber = $_POST["phone"];
     } else {
       $msg = "Duplicate Phone Number Found";
     }
     $superSsn = getSuperSsn($db, $isDevelopment);
     $emp_id = createEmployeeID($db, $isDevelopment);
     $dob = $_POST["birth_date"];
     $startDate = $_POST["startDatepicker"];
     $address = $_POST["address"];
     $gender = $_POST["sex"];
     $wage = $_POST["Wage"];
     $dno = $_SESSION['dno'];
     
     if(!checkDuplicateSsn($uniqueInfos) && !checkDuplicateUsername($uniqueInfos) && !checkDuplicatePassword($uniqueInfos) && !checkDuplicatePhoneNumber($uniqueInfos)){
       $query = "insert into employee values ('$name', $ssn, $superSsn, $emp_id, '$dob', '$startDate', '$address', '$gender', $wage, $dno, $phoneNumber, '$username', '$password');";
       
       if($isDevelopment) {
         $result = pg_query($db, $query);
       } else {
         $result = $db->query($query);
       }
       $msg = "Employee: $name was successfully created.";
     }
   }
     
   return $msg;
}
?>
<?php
function gatherInfo($db, $isDevelopment) {
  $query = "SELECT ssn, employee_username, employee_password, phone_number FROM employee;";
  $data = array();
  if($isDevelopment) {
    $result = pg_query($db, $query);
    while($row = pg_fetch_row($result)) {
      $data[] = array('ssn' => $row[0], 'employee_username' => $row[1], 'employee_password' => $row[2], 'phone_number' => $row[3]);
    }
  } else {
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $data[] = array('ssn' => $row['ssn'], 'employee_username' => $row['employee_username'], 'employee_password' => $row["employee_password"], "phone_number" => $row["phone_number"]);
    }
  }
  
  return $data;
}
?>

<?php
function createEmployeeID($db, $isDevelopment) {
  $data = array();
  $currentId = 0;
  $query = "SELECT employee_id FROM employee;";
  if($isDevelopment) {
    $results = pg_query($db, $query);
    while($row = pg_fetch_row($results)) {
      if($row[0] > $currentId) {
        $currentId = $row[0];
      }
    }
  } else {
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      if($row["employee_id"] > $currentId) {
        $currentId = $row["employee_id"];
      }
    }
  }
  
  $newEmpId = $currentId + 1;
  return $newEmpId;
}
?>

<?php
function getSuperSsn($db, $isDevelopment) {
  $empId= $_SESSION['emp_id'];
  $query = "SELECT ssn from employee WHERE $empId=employee_id";
  if($isDevelopment) {
    $result = pg_query($db, $query);
    while($row = pg_fetch_row($result)) {
      $superSsn = $row[0];
    }
  } else {
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $superSsn = $row["ssn"];
    }
  }
  
  return $superSsn;
}
?>
<?php
function checkDuplicateSsn($infos) {
  $result = false;
  foreach($infos as $info) {
    $socialNum = $info['ssn'] ?? null;
    if($socialNum == $_POST["SSN"]){
      $result = true;
    } 
  }
  return $result;
}
?>

<?php
function checkDuplicateUsername($infos) {
  $result = false;
  foreach($infos as $info) {
    $user = $info['employee_username'] ?? null;
    if($user == $_POST["username"]){
      $result = true;
    } 
  }
  return $result;
}
?>

<?php
function checkDuplicatePassword($infos) {
  $result = false;
  foreach($infos as $info) {
    $pass = $info['employee_password'] ?? null;
    if($pass == $_POST["password"]){
      $result = true;
    } 
  }
  return $result;
}
?>

<?php
function checkDuplicatePhoneNumber($infos) {
  $result = false;
  foreach($infos as $info) {
    $pass = $info['phone_number'] ?? null;
    if($pass == $_POST["phone"]){
      $result = true;
    } 
  }
  return $result;
}
?>