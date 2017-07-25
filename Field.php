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
	$user = XDB::I()->FetchDataRow("SELECT pl_name FROM player WHERE pl_id=@id", array('id' => $_POST['name']));
    if(!empty($user))
    {		
    $_SESSION['USER'] = $_POST['name'];
	}
	else
	{	
	  echo 'Ошибка id,попробуйте снова.</br>';
	}
}

if(!empty($_GET['exit']))
{
	$_SESSION['USER'] = array();
}


if(!empty($_SESSION['USER']))
{
	$user_aut = $_SESSION['USER'];
	$user = XDB::I()->FetchDataRow("SELECT pl_name FROM player WHERE pl_id=@id", array('id' => $user_aut));
    $usern = $user[pl_name];
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

//Запрос на добавление строки



//Запрос к таблице Move



if($_REQUEST['push'] == 1)
{	
 $idcelly = $_GET['idcelly'];
 $idcellx = $_GET['idcellx'];
 $idPlayerMain = $_GET['idplayer'];
 $IdGameNumber = $_GET['idgame'];
 $idMove_number = $_GET['idhod'];
 
$moveInfo = XDB::I()->FetchCollection("SELECT * FROM move WHERE mv_game_id=@id AND mv_cellx=@cellx AND mv_celly=@celly", array('id' => $IdGameNumber, 'cellx' => $idcellx,'celly' => $idcelly));
   
   if(empty($moveInfo))
     {
        $result = XDB::I()->Insert('move', array (
        'mv_player_id' => $idPlayerMain,
        'mv_celly' => $idcelly,
        'mv_cellx' => $idcellx,
        'mv_game_id' => $IdGameNumber,
        'mv_number' => $idMove_number
        )
        );
    }
	echo 'Ид игрока: ' . $idPlayerMain . '</br>';
    echo 'Координата У: ' . $idcelly . '</br>';
    echo 'Координата Х: ' . $idcellx . '</br>';
    echo 'Номер игры: ' . $IdGameNumber . '</br>';
    echo 'Номер хода: ' . $idMove_number . '</br>';
}

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
////////Извлечение данных из баз.//////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

//Запрос к таблице Game

$gameInfo = XDB::I()->FetchDataRow("SELECT * FROM game WHERE (gm_player1_id=@id OR gm_player2_id=@id) AND gm_winner<1", array('id' => $user_aut));
//print_r($gameInfo);
echo '</br>';

$gameNumber = $gameInfo['gm_id'];
$gmSymbol1 =  $gameInfo['gm_symbol1'];
$gmSymbol2 =  $gameInfo['gm_symbol2'];
$player1 = $gameInfo['gm_player1_id'];
$player2 = $gameInfo['gm_player2_id'];
echo 'Номер игры: ' . $gameNumber;
echo '</br>';
echo 'Ид Первого игрока: ' . $player1;
echo '</br>';
echo 'Ид Второго игрока: ' . $player2;
echo '</br>';

$moveInfo = XDB::I()->FetchCollection("SELECT * FROM move WHERE mv_game_id=@id", array('id' => $gameNumber));

//Определение хода

$move_number = count($moveInfo);
echo '</br>';
echo 'Число ходов: ' . $move_number . '</br>';
echo '</br>';

//Информация хода

if($move_number % 2 == 0)
{
	echo '</br>';
	echo 'Ход крестиков,нолики ожидайте.';
	echo '</br>';
}
else
{   
    echo '</br>';
	echo 'Ход ноликов,крестики ожидайте.';
	echo '</br>';
}

//Смена хода

if($move_number % 2 == 0)
{
	$playerMain = $player1;
	$mainSymbol = $gmSymbol1;

}
else
{   
    if($move_number % 2 != 0)
	{
    $playerMain = $player2;
	$mainSymbol = $gmSymbol2;
	}
}
	

	
	
echo 'Значение playerMain: ' . $playerMain;
echo '</br>';
echo 'Значение user_aut: ' . $user_aut;
echo '</br>';

//print_r($moveInfo);
echo '</br>';


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

/* 
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
*/
//Формирование заполненных ячеек поля

for($i = 0;$i < $move_number;$i++)
{
	if($i % 2 != 0)
{
	$mainSymbol = $gmSymbol2;
}
else
{   
	$mainSymbol = $gmSymbol1;
}
$celly = $moveInfo[$i]['mv_celly'];
$cellx = $moveInfo[$i]['mv_cellx'];
$gameMassive['cells'][$celly][$cellx] = $mainSymbol;
//print_r($gameMassive);
//echo '</br>';
//echo '</br>';
}

// $idcelly = $_GET['idcelly'];
// $idcellx = $_GET['idcellx'];
// $_SESSION['cells'][$idcelly][$idcellx] = $znach;
 
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
        if(empty($gameMassive['cells'][$y][$x]) && ($playerMain == $user_aut))// && ($_SESSION['win'] == 0))
        {
            echo '<a href="Field.php?idplayer=' . $playerMain . '&idcelly=' . $y . '&idcellx=' . $x . '&idgame=' . $gameNumber . '&idhod=' . $move_number . '&push=1"><div style="width:30px; height:30px;"></div></a>';
        }
        echo $gameMassive['cells'][$y][$x];
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