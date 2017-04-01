<?php
  include 'app/base.php';
  $twig = loadEnvironment();
  $loginLink = "http://ta_code.dev/index.php";
  $isDevelopment = false;
  $db = loadDB($isDevelopment);
  $result = pg_query($db, "SELECT ride_id,name, FROM ride");
  $numrows = pg_numrows($result);
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
    <table border="1">
    <tr>
      <th>Name</th>
      <th>ID</th>
    </tr>
  <?
   </thead>
   <tbody>
  <?php
$query = "SELECT ride_id, name, dno"
     . "FROM employee ORDER BY name ASC";
$result = $db->query($query);
// Loop on rows in the result set.

   for($ri = 0; $ri < $numrows; $ri++) {
    echo "<tr>\n";
    $row = pg_fetch_array($result, $ri);
    echo " <td>", $row["name"], "</td>
   <td>", $row["ride_id"], "</td>
  </tr>
  ";
   }
$result->closeCursor();
?>
   </tbody>
  </table>
 </body>
</html>
