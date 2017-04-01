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
   <title>Database</title>
  </head>

  <body bgcolor="white">

  <?
  $isDevelopment = false;
  $db = loadDB($isDevelopment);
  $result = pg_query($db, "SELECT ride_id,name, FROM ride");
  $numrows = pg_numrows($result);
  ?>

  <table border="1">
  <tr>
   <th>Name</th>
   <th>ID</th>
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
   pg_close($link);
  ?>
  </table>

  </body>

  </html>
