# Tracking
<?php
  //Step over if cookie is
  if (!isset($_COOKIE["SITE_VISITED"])) {  already set
    setcookie('SITE_VISITED', 'X');
    $db = mysqli_connect('localhost', 'bfu', '1234', 'visits');
    //Do we already have a record in the DB?
    $res = mysqli_query($db, sprintf("SELECT * FROM visits WHERE ipaddr='%s';",$_SERVER['REMOTE_ADDR']));
    if ($res === FALSE && $res->num_rows = 0) {
      //Record in DB not found, let's create one
      $res2 = mysqli_query($db, sprintf("INSERT INTO visits('ipaddr','page') VALUES ('%s','%s');",$_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI']));
    }
    mysqli_close($res);
  }
?>
