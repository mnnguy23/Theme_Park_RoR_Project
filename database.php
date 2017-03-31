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

<html>
 <head>
  <title>Attractions</title>
 </head>
 <body>
  <table>
   <thead>
    <tr>
     <th>Attraction ID</th>
     <th>Attraction Name</th>
     <th>Price</th>
    </tr>
   </thead>
   <tbody>
<?php
$query = "SELECT ride_id, name, date_built"
     . "FROM employee";
$result = $db->query($query);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["ride_id"] . "</td>";
    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
    echo "<td>" . $row["date_built"] . "</td>";
    echo "</tr>";
}
$result->closeCursor();
?>
   </tbody>
  </table>
 </body>
</html>
