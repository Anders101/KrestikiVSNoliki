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

$_SESSION['c1'] = '-' . '<br />';
$_SESSION['c2'] = '-' . '<br />'; 
$_SESSION['c3'] = '-' . '<br />'; 
$_SESSION['c4'] = '-' . '<br />';
$_SESSION['c5'] = '-' . '<br />'; 
$_SESSION['c6'] = '-' . '<br />';
$_SESSION['c7'] = '-' . '<br />'; 
$_SESSION['c8'] = '-' . '<br />';
$_SESSION['c9'] = '-' . '<br />';


echo 'значение ячейки 1: ' . $_SESSION['c1'] . '<br />';
echo 'значение ячейки 2: ' . $_SESSION['c2'] . '<br />';

$a1 = $_GET['b'];
echo '<a href="field.php?b=2"> Меняем значение первой ячейки на 2 </a><br />';
$_SESSION['c1'] = $a1;
echo 'значение первой ячейки : ' . $_SESSION['c1'] . '<br />';

$a2 = $_GET['b2'];
echo '<a href="field.php?b2=3"> Меняем значение второй ячейки на 3 </a><br />';
$_SESSION['c2'] = $a2;
echo 'значение первой ячейки : ' . $_SESSION['c2'] . '<br />';


echo 'значение первой ячейки : ' . $_SESSION['c1'] . '<br />';
echo 'значение первой ячейки : ' . $_SESSION['c2'] . '<br />';

echo '<a href="field.php?b=5&b2=5"> Меняем значение первой и второй ячееки на 5 </a><br />';

echo 'значение первой ячейки : ' . $_SESSION['c1'] . '<br />';
echo 'значение первой ячейки : ' . $_SESSION['c2'] . '<br />';

?>

 <table bordercolor="red" border=2 align="center" >
 <tr><td height="30" width="30" align= "center">
 <?php 
    $a1 = $_GET['b'];
    echo '<a href="field.php?b=2&b2=' . $a2 . '">-</a>';
    $_SESSION['c1'] = $a1;
    echo $_SESSION['c1'];
 ?>
 </td>
 <td height="30" width="30" align= "center">
 <?php
     $a2 = $_GET['b2'];
    echo '<a href="field.php?b=' . $a1 . '&b2=2&b3=' . $a3 .'&b4=' . $a4 .'&b5=' . $a5 .'&b6=' . $a6 .'&b7=' . $a7 .
	'&b8=' . $a8 .'&b9=' . $a9 .'">-</a>';
    $_SESSION['c2'] = $a2;
    echo $_SESSION['c2'];
?>
 </td>
 <td height="30" width="30" align= "center">
 <?php
     $a3 = $_GET['b3'];
    echo '<a href="field.php?b=' . $a1 . '&b2=' . $a2 .'&b3=2&b4=' . $a4 .'&b5=' . $a5 .'&b6=' . $a6 .'&b7=' . $a7 .
	'&b8=' . $a8 .'&b9=' . $a9 .'">-</a>';
    $_SESSION['c3'] = $a3;
    echo $_SESSION['c3'];
?> 
 </td></tr>
 <tr><td height="30" width="30" align= "center">
  <?php
     $a4 = $_GET['b4'];
    echo '<a href="field.php?b=' . $a1 . '&b2=' . $a2 .'&b3=' . $a3 .'&b4=2&b5=' . $a5 .'&b6=' . $a6 .'&b7=' . $a7 .
	'&b8=' . $a8 .'&b9=' . $a9 .'">-</a>';
    $_SESSION['c4'] = $a4;
    echo $_SESSION['c4'];
?> 
 </td><td height="30" width="30" align= "center">
  <?php
     $a5 = $_GET['b5'];
    echo '<a href="field.php?b=' . $a1 . '&b2=' . $a2 .'&b3=' . $a3 .'&b4=' . $a4 .'&b5=2&b6=' . $a6 .'&b7=' . $a7 .
	'&b8=' . $a8 .'&b9=' . $a9 .'">-</a>';
    $_SESSION['c5'] = $a5;
    echo $_SESSION['c5'];
?>  
 </td><td height="30" width="30" align= "center">
   <?php
     $a6 = $_GET['b6'];
    echo '<a href="field.php?b=' . $a1 . '&b2=' . $a2 .'&b3=' . $a3 .'&b4=' . $a4 .'&b5=' . $a5 .'&b6=2&b7=' . $a7 .
	'&b8=' . $a8 .'&b9=' . $a9 .'">-</a>';
    $_SESSION['c6'] = $a6;
    echo $_SESSION['c6'];
?>  
 
 </td></tr>
 <tr><td height="30" width="30" align= "center">
    <?php
     $a7 = $_GET['b7'];
    echo '<a href="field.php?b=' . $a1 . '&b2=' . $a2 .'&b3=' . $a3 .'&b4=' . $a4 .'&b5=' . $a5 .'&b6=' . $a5 .'&b7=2' .
	'&b8=' . $a8 .'&b9=' . $a9 .'">-</a>';
    $_SESSION['c7'] = $a7;
    echo $_SESSION['c7'];
?>  
 </td><td height="30" width="30" align= "center">
<?php
    $a8 = $_GET['b8'];
    echo '<a href="field.php?b=' . $a1 . '&b2=' . $a2 .'&b3=' . $a3 .'&b4=' . $a4 .'&b5=' . $a5 .'&b6=' . $a5 .'&b7=' . $a7 .
	'&b8=2&b9=' . $a9 .'">-</a>';
    $_SESSION['c8'] = $a8;
    echo $_SESSION['c8'];
?>  
 </td><td height="30" width="30" align= "center">
 <?php
    $a9 = $_GET['b9'];
    echo '<a href="field.php?b=' . $a1 . '&b2=' . $a2 .'&b3=' . $a3 .'&b4=' . $a4 .'&b5=' . $a5 .'&b6=' . $a5 .'&b7=' . $a7 .
	'&b8=' . $a8 .'&b9=2">-</a>';
    $_SESSION['c9'] = $a9;
    echo $_SESSION['c9'];
?>  
 </td></tr>
 </table>

?>
 </body>
</html>