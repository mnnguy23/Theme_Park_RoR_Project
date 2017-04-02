<?php
  include 'app/base.php';
  include 'app/indexFunctions.php';
  $twig = loadEnvironment();
  $isDevelopment = false;
  $clearSession = developmentMode($isDevelopment);
  $dbConn = loadDB($isDevelopment);
?>

<?php
  $template = $twig->load('index.html');
  list($users, $passwords) = queryUserAccess($dbConn, $isDevelopment);
  $msg = checkCredential($users, $passwords);
  echo $template->render(array('msg' => $msg, 'clear' => $clearSession));
?>

<?php
  function pg_list_tables($dbConn) {
    $sql = "select relname from pg_stat_user_tables order by relname;";
    return pg_query($dbConn, $sql);
  }
?>

<html>
  <body bgcolor="white">
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
