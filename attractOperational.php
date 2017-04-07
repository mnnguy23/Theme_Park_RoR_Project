
<?php
function getAttractions($db, $isDevelopment) {
  $data = array();
  if($isDevelopment) {
    $query = "SELECT attraction_id, name FROM public.attraction;";
    $results = pg_query($db, $query);
    while($row = pg_fetch_row($results)) {
      $attract_id = $row[0];
      $name = trim($row[1]);
      $data[$attract_id] = $name;
    }
  } else {
    $query = "SELECT attraction_id, name FROM attraction;";
    $result = $db->query($query);
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $attract_id = $row['attraction_id'];
      $name = trim($row['name']);
      $data[$row[$attract_id]] = $row[$name];
    }
    $result->closeCursor();
  } 
  return $data;
}
?>

<?php
function setRideInoperable($db, $rides, $isDevelopment) {
  $response = "Set a ride inoperable.";
  if(isset($_POST['notOperational']) && !empty($_POST["attractionName"])) {
    $rideName = $_POST["attractionName"];
    $attraction_id = '';
    
    foreach($rides as $key => $value) {
      if(strcmp($rideName, $value) == 0 ) {
        $attraction_id = $key;
        $response = "this ride: $rideName is now set to not operational.";
      }
    }
    
      $currentTime = (new \DateTime())->format('Y-m-d H:i:s');
      $query = "UPDATE attraction SET operational = FALSE WHERE attraction_id = $attraction_id;";
      if($isDevelopment) {
        $result = pg_query($db, $query); 
      } else {
        $result = $db->query($query);
      }
  }
  return $response;
}
?>