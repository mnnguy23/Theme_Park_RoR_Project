<html>
  <head>
   <title>Attractions</title>
  </head>
  
  <body bgcolor="white">

  <?
  $db = loadDB($isDevelopment);
  $result = pg_query($db, "select ride_id,name from ride");
  $numrows = pg_numrows($result);
  ?>
  <?php
         echo "<h1>Hello, PHP!</h1>";
  ?>
  <table border="1">
  <tr>
   <th>Ride ID</th>
   <th>Name</th>
  </tr>
  <?
   // Loop on rows in the result set.
   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["ride_id"], "</td>
   <td>", $row["name"], "</td>
  </tr>
  ";
   }
   pg_close($db);
  ?>
  </table>
  </body>
</html>
