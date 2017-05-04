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


echo '<a href="field.php?newgame=1&idcell=11&znachhod=1">Обновить ячейки и установить ход крестиков</a>';
if(!empty($_GET['newgame']))
{
	$_SESSION['cells'] = array();
}


 $idcell = $_GET['idcell'];
 $znach = $_GET['znach'];
 $znachhod = $_GET['znachhod'];
 $_SESSION['cells'][$idcell] = $znach;
 $_SESSION['cells'][11] = $znachhod;


?>

 <table bordercolor="red" border=2 align="center" >
 <tr><td height="30" width="30" align= "center">
 <?php
 if(empty($_SESSION['cells'][0]) && $znachhod == 1)
 {
 echo '<a href="Field.php?idcell=0&znach=X&znachhod=2">-</a>';
 }
 else
 {
	if(empty($_SESSION['cells'][0]) && $znachhod == 2)
	{
	echo '<a href="Field.php?idcell=0&znach=O&znachhod=1">-</a>';	
	}
 }
echo $_SESSION['cells'][0];
?>
 </td>
 <td height="30" width="30" align= "center">
 <?php
 if(empty($_SESSION['cells'][1]) && $znachhod == 1)
 {
 echo '<a href="Field.php?idcell=1&znach=X&znachhod=2">-</a>';
 }
 else
 {
	if(empty($_SESSION['cells'][1]) && $znachhod == 2)
	{
	echo '<a href="Field.php?idcell=1&znach=O&znachhod=1">-</a>';	
	}
 }
 echo $_SESSION['cells'][1];
 
?>
 </td>
</tr>
 </table>


 </body>
</html>