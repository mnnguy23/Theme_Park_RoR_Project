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
  $db = loadDB($isDevelopment);
  $result = pg_query($db, "select ride_id,name from ride") or die('Query failed: ' . pg_last_error());
  $numrows = pg_numrows($result);
?>
<html>
  <head>
   <title>Attractions</title>
  </head>
  
  <body bgcolor="white">
    
  <table border="1">
  <tr>
   <th>Ride ID</th>
   <th>Name</th>
  </tr>
    $result = pg_query($db, "select ride_id,name from ride") or die('Query failed: ' . pg_last_error());
    $numrows = pg_numrows($result);
  <?
   // Loop on rows in the result set.
   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["attraction_id"], "</td>
   <td>", $row["name"], "</td>
  </tr>
  ";
   }
   pg_close($db);
  ?>
  </table>
  </body>
</html>
