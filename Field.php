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


echo '<a href="field.php?newgame=1">Обновить</a><br />';
if(!empty($_GET['newgame']))
{
	$_SESSION['cells'] = array();
}

if($_GET['newgame'] == 1)
{
	$_SESSION['Hod'] = 1;
}
 
if($_SESSION['Hod'] == 1)
{
	$znach = 'X';
	echo 'Ход крестиков';
	$_SESSION['Hod'] = 2;
	$znach = 'O';
}
else
{
	$znach = 'O';
	echo 'Ход ноликов';
	$_SESSION['Hod'] = 1;
	$znach = 'X';
}

 $idcell = $_GET['idcell'];
 $_SESSION['cells'][$idcell] = $znach;

?>

 <table bordercolor="red" border=2 align="center" >
 <tr>
<?php

$j = 9;

for($i = 0; $i < $j; $i++)
{
?>
 <td height="30" width="30" align= "center">
 <?php
 if(empty($_SESSION['cells'][$i]))
 {
 echo '<a href="field.php?idcell=' . $i . '">-</a>';
 }
 echo $_SESSION['cells'][$i];
?>
 </td>
<?php
}
?>

 </td>
</tr>
 </table>
 </body>
</html>