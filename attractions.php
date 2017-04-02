<html>
  <head>
   <title>Attractions</title>
  </head>
  
  <body bgcolor="white">

  <?
  $db = loadDB($isDevelopment)  or die('Could not connect: ' . pg_last_error());
  $result = pg_query($db, "select ride_id,name from ride") or die('Query failed: ' . pg_last_error());
  $numrows = pg_numrows($result);
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
