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
