<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Крестики VS Нолики.</title>
  <link rel="stylesheet" type="text/css" href="" />
</head>
<body>
<?php

session_start();

$_SESSION['cells'][$idcell];


?>

 <table bordercolor="red" border=2 align="center" >
 <tr><td height="30" width="30" align= "center">
 <?php
 echo '<a href="field.php?idcell=0&znach=X">-</a>';
 $idcell = $_GET['idcell'];
 $znach = $_GET['znach'];
 $_SESSION['cells'][$idcell] = $znach;
 echo $_SESSION['cells'][$idcell];
?>
 </td>
 <td height="30" width="30" align= "center">
 <?php
 echo '<a href="field.php?idcell=1&znach=0">-</a>';
  $idcell = $_GET['idcell'];
 $znach = $_GET['znach'];
 $_SESSION['cells'][$idcell] = $znach;
 echo $_SESSION['cells'][$idcell];
?>
 </td>
</tr>
 </table>


 </body>
</html>