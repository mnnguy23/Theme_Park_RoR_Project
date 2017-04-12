<?php
function queryReport($db, $dno) {
  $table = "";
  $date = "";
  $info = "";
  if($dno == 1) {
    $table = "attraction_attendance";
    $date = 'a_date';
    $info = "a_attendance";
  } elseif($dno == 2) {
    $table = "merchandise_sales";
    $date = "m_date";
    $info = "m_sales";
  } elseif($dno == 4) {
    $table = "game_sales";
    $date = 'gs_date';
    $info = "player_counts";
  }
  $data = array();
  $query = reportQuery($table, $date, $info);
  $result = $db->query($query);
  while($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $newArray = postgres_to_phpArray($row[$info]);
    $data[] = array($row[$date], $newArray);
  }
  $result->closeCursor();
  return $data;
}
?>
<?php
function reportQuery($table, $date, $info){
  $query = "SELECT $date, $info from $table;";
  if(isset($_POST["submit"]) && !empty($_POST["startDatepicker"]) && !empty($_POST["endDatepicker"])) {
    if($_POST["startDatepicker"] < $_POST["endDatepicker"]) {
      $startDate = $_POST["startDatepicker"];
      $endDate = $_POST["endDatepicker"];
      $query = "SELECT $date, $info from $table WHERE $date BETWEEN '$startDate' AND '$endDate' ORDER BY $date DESC;";
    }
  }
  return $query;
}
?>
<?php
function postgres_to_phpArray($postgresArray) {
  $postgresStr = trim($postgresArray,"{}");
  $elmts =  explode(",",$postgresStr);
  $data = array();
  foreach($elmts as $element)
  {
    $data[] = (int)$element;
  }
  return $data;
}
?>

<?php
function getTimeLogs($logs) {
  return $logs[0];
}
?>

<?php
function getAmountLogs($logs) {
  return $logs[1];
}
?>