<?php
include 'app/base.php';
$twig = loadEnvironment();
  $loginLink = "http://ta_code.dev/index.php";
?>

<?php
  $template = $twig->load('menu.html');
  echo $template->render(array('login' => $loginLink)); 
?>

<html>
 <head>
  <title>Attractions</title>
 </head>
 <body>
  <table>
   <thead>
    <tr>
     <th>Ride ID</th>
     <th>Name</th>
     <th>Department Number</th>
    </tr>
   </thead>
   <tbody>
<?php
$query = "SELECT ride_id, name, dno"
     . "FROM employee ORDER BY name ASC";
$result = $db->query($query);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["ride_id"] . "</td>";
    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["dno"]) . "</td>";
    echo "</tr>";
}
$result->closeCursor();
?>
   </tbody>
  </table>
 </body>
</html>
