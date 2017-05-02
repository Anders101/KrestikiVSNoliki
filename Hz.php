<?php
//ini_set(session.use_cookies=1);
session_start();

$massiv = array($x1, $x2);

$_SESSION['c1'] = '-' . '<br />';
$_SESSION['c2'] = '-' . '<br />'; 


echo 'значение ячейки 1: ' . $_SESSION['c1'] . '<br />';
echo 'значение ячейки 2: ' . $_SESSION['c2'] . '<br />';

$a1 = $_GET['b'];
echo '<a href="hz.php?b=2"> Меняем значение первой ячейки на 2 </a><br />';
$_SESSION['c1'] = $a1;
echo 'значение первой ячейки : ' . $_SESSION['c1'] . '<br />';

$a2 = $_GET['b2'];
echo '<a href="hz.php?b2=3"> Меняем значение второй ячейки на 3 </a><br />';
$_SESSION['c2'] = $a2;
echo 'значение первой ячейки : ' . $_SESSION['c2'] . '<br />';


echo 'значение первой ячейки : ' . $_SESSION['c1'] . '<br />';
echo 'значение первой ячейки : ' . $_SESSION['c2'] . '<br />';

echo '<a href="hz.php?b=5&b2=5"> Меняем значение первой и второй ячееки на 5 </a><br />';

echo 'значение первой ячейки : ' . $_SESSION['c1'] . '<br />';
echo 'значение первой ячейки : ' . $_SESSION['c2'] . '<br />';

echo 'значение первой ячейки : ' . $a1 . '<br />';
echo 'значение первой ячейки : ' . $a2 . '<br />';




echo 'Применение МАССИВА : <br />';
echo '<br />';
echo '<br />';

$a2 = $_GET['b2'];
echo '<a href="hz.php?b2=3"> Меняем значение первой ячейки на 3 </a><br />';
$_SESSION['c1'] = $a2;
$massiv[0] = $_SESSION['c1'];
echo 'значение первой ячейки : ' . $massiv['0'] . '<br />';

$a1 = $_GET['b1'];
echo '<a href="hz.php?b2=4"> Меняем значение второй ячейки на 4 </a><br />';
$_SESSION['c1'] = $a1;
$massiv[1] = $_SESSION['c1'];
echo 'значение первой ячейки : ' . $massiv['1'] . '<br />';


echo 'значение первой ячейки : ' . $_SESSION['c1'] . '<br />';
echo 'значение первой ячейки : ' . $_SESSION['c2'] . '<br />';

echo '<a href="hz.php?b=5&b2=5"> Меняем значение первой и второй ячееки на 5 </a><br />';

echo 'значение первой ячейки : ' . $_SESSION['c1'] . '<br />';
echo 'значение первой ячейки : ' . $_SESSION['c2'] . '<br />';

echo 'значение первой ячейки : ' . $a1 . '<br />';
echo 'значение первой ячейки : ' . $a2 . '<br />';
?>