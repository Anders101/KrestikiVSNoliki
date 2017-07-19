<?php

define('DBBASE', 'gamedata');
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', ''); 

session_start();
?>

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

include 'db.cls.php';
include 'exception.cls.php';

$user_aut = $_POST['name'];

if(!empty($_POST['name']))
{
	$user = XDB::I()->FetchDataRow("SELECT pl_name FROM player WHERE pl_id=@id", array('id' => $user_aut));
    if(!empty($user))
    {		
    $_SESSION['USER'] = $user_aut;
	}
	else
	{	
	  echo 'Ошибка id,попробуйте снова.</br>';
	}
}


$user = XDB::I()->FetchDataRow("SELECT pl_name FROM player WHERE pl_id=@id", array('id' => $user_aut));
$usern = $user[pl_name];

if(!empty($_GET['exit']))
{
	$_SESSION['USER'] = array();
}


if(!empty($_SESSION['USER']))
{
	echo 'Здравствуйте   ';
    print_r($usern);	
    echo '</br>';
}
else
{
	echo   '<form action="field.php" method="post">
       <p>Ваше имя: <input type="text" name="name" /></p>
       <p><input type="submit" value="Войти"/></p>
       </form>';
	exit;
}

if(!empty($_SESSION['USER']))
{
echo '<a href="field.php?exit=1">Выход</a><br />';
}

echo '</br>';


echo '<a href="Field.php?newgame=1">Новая игра</a><br />';
if(!empty($_GET['newgame']))
{
	$_SESSION['cells'] = array();
}

if($_GET['newgame'] == 1)
{
	$_SESSION['Hod'] = 1;
	$_SESSION['win'] = 0;
}
 
if($_SESSION['Hod'] == 1)
{
	echo 'Ход крестиков<br />';
	$_SESSION['Hod'] = 2;
	$znach = 'O';
}
else
{
	echo 'Ход ноликов<br />';
	$_SESSION['Hod'] = 1;
	$znach = 'X';
}

 $idcelly = $_GET['idcelly'];
 $idcellx = $_GET['idcellx'];
 $_SESSION['cells'][$idcelly][$idcellx] = $znach;
 
//Размеры поля
$sizeY = 3;
$sizeX = 3;


////////////////////////////////////
//////////////ФУНКЦИИ///////////////
////////////////////////////////////

//Функция отображения победителя

function champ($countIf, $playerSymbol)
{ 
  if($countIf == 1)
  {
    if($playerSymbol == 'X')
    {
	  $_SESSION['win'] = 1;
    }
    else
      {
	    if($playerSymbol == 'O')
	    {
		  $_SESSION['win'] = 2;
	    }		
      }
  }
}


//Функция проверки ячеек

function isArraySolid($array, $sizeX)
{
	$allCellsSame = 1;
   for($x = 0; $x < $sizeX; $x++)
   {
        if($x == 0)
        {
            $symbol = $array[$x];
        }
        else
        {
            if($symbol != $array[$x])
            {
            $allCellsSame = 0;
			break;
            }
        }
    }
    return array($allCellsSame, $symbol);
}

//Проверка по горизонтали

for($y = 0; $y < $sizeY; $y++)
{
   $row = $_SESSION['cells'][$y];
   list($allCellsSame, $photo) = isArraySolid($row, $sizeX);
   champ($allCellsSame, $photo);
}


//Проверка По вертикали
for($x = 0; $x < $sizeX; $x++)
{
	for($y = 0; $y < $sizeY; $y++)
    {
	$promMass[$y] = $_SESSION['cells'][$y][$x];
    }
	list($allCellsSame, $photo) = isArraySolid($promMass, $sizeX);
	champ($allCellsSame, $photo);
}


//Проверка по диагонали слева направо

	for($x = 0;$x < $sizeX;$x++)
	{
		$y = $x;
		$promMass[$y] = $_SESSION['cells'][$y][$x];
	}
	list($allCellsSame, $photo) = isArraySolid($promMass, $sizeX);
    champ($allCellsSame, $photo);

//Проверка диагонали справа налево
$x = ($sizeX - 1);
    for($y = 0;$y < $sizeY;$y++)
	{
		$promMass[$y] = $_SESSION['cells'][$y][$x];
		$x--;
	}
	list($allCellsSame, $photo) = isArraySolid($promMass, $sizeX);
    champ($allCellsSame, $photo);


if($_SESSION['win'] == 1)
{
	echo 'Победа Крестиков';
}
else if($_SESSION['win'] == 2)
{
	echo 'Победа Ноликов';
}

?>

 <table bordercolor="red" border=2 align="center" >
 <tr>
<?php

//Отображение игрового поля

for($y = 0; $y < $sizeY; $y++)
{
    for($x = 0; $x < $sizeX; $x++)
    {
 ?>
<td height="30" width="30" align= "center" >
 <?php
        if(empty($_SESSION['cells'][$y][$x]) && ($_SESSION['win'] == 0))
        {
            echo '<a href="Field.php?idcelly=' . $y . '&idcellx=' . $x . '"><div style="width:30px; height:30px;"></div></a>';
        }
        echo $_SESSION['cells'][$y][$x];
?>
 </td>
<?php
	    if($x == ($sizeX - 1))
	    {
		    echo '</tr><tr><br />';
	    }
    }
}
?>

 </td>
</tr>
 </table>
 </body>
</html>