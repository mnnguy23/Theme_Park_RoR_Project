<?php
$dsn = "pgsql:"
    . "ec2-50-17-236-15.compute-1.amazonaws.com;"
    . "d2641hluvfmus5;"
    . "user=nqxatreczgovme;"
    . "port=5432;"
    . "sslmode=require;"
    . "password=91ef1bd79a01039737b248bdc7a465b27b284af93a537cfd217a5135d94f95d8";

$db = new PDO($dsn);
?>

<html>
 <head>
  <title>Employees</title>
 </head>
 <body>
  <table>
   <thead>
    <tr>
     <th>Employee ID</th>
     <th>Last Name</th>
     <th>First Name</th>
    </tr>
   </thead>
   <tbody>
<?php
$query = "SELECT ssn, lname, fname, title "
     . "FROM employees ORDER BY lname ASC, fname ASC";
$result = $db->query($query);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . $row["ssn"] . "</td>";
    echo "<td>" . htmlspecialchars($row["lname"]) . "</td>";
    echo "<td>" . htmlspecialchars($row["fname"]) . "</td>";
    echo "</tr>";
}
$result->closeCursor();
?>
   </tbody>
  </table>
 </body>
</html>
