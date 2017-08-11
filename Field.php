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
	  echo 'Ваш id не зарегестрирован,попробуйте снова.</br>';
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
    $usern = $user['pl_name'];
	echo 'Здравствуйте   ';
    echo $usern;	
    echo '</br>';
	echo '  Ваш id: ' . $user_aut;
	echo '</br>';
	echo '</br>';
}
else
{
	echo   '<form action="field.php" method="post">
       <p>Ваш id: <input type="text" name="name" /></p>
       <p><input type="submit" value="Войти"/></p>
       </form>';
	exit;
}

//Запрос на id игры

if((empty($_GET['idgame'])) && (!empty($_SESSION['USER'])))
{
		echo '<a href="field.php?idgame=">Введите номер игры</a></br>';
		exit;
}

//Проверка участника по id игры

if(!empty($_GET['idgame']))
{
    $idGameEnter = $_GET['idgame'];
    $gameInfo = XDB::I()->FetchDataRow("SELECT * FROM game WHERE gm_id=@id", array('id' => $idGameEnter));
	$gameStatus = $gameInfo['gm_winner'];
    $player1Ent = $gameInfo['gm_player1_id'];
    $player2Ent	= $gameInfo['gm_player2_id'];
}

//Проверка участвует ли игрок в данной игре?

if(($_SESSION['USER'] != $player1Ent) && ($_SESSION['USER'] != $player2Ent))
{
	echo 'Ошибка,вы не участвуете в этой игре,попробуйте другую!</br>';
	echo '<a href="field.php?exit=1">Выход</a><br />';
	exit;
}
else
{
	if(!empty($gameStatus))
	{
		echo 'Игра уже законна.Попробуйте другую!</br>';
	    echo '<a href="field.php?exit=1">Выход</a><br />';
	    //exit;
	}
}

//Запрос к таблице Move добавление данных хода в таблицу



if($_REQUEST['push'] == 1)
{	
 $idcelly = $_GET['idcelly'];
 $idcellx = $_GET['idcellx'];
 $idPlayerMain = $_GET['idplayer'];
 $idGameNumber = $_GET['idgame'];
 $idMove_number = $_GET['idhod'];
 
$moveInfo = XDB::I()->FetchCollection("SELECT * FROM move WHERE mv_game_id=@id AND mv_cellx=@cellx AND mv_celly=@celly", array('id' => $idGameNumber, 'cellx' => $idcellx,'celly' => $idcelly));
   
   if(empty($moveInfo))
     {
        $result = XDB::I()->Insert('move', array (
        'mv_player_id' => $idPlayerMain,
        'mv_celly' => $idcelly,
        'mv_cellx' => $idcellx,
        'mv_game_id' => $idGameNumber,
        'mv_number' => $idMove_number
        )
        );
    }
	echo 'Ид игрока: ' . $idPlayerMain . '</br>';
    echo 'Координата У: ' . $idcelly . '</br>';
    echo 'Координата Х: ' . $idcellx . '</br>';
    echo 'Номер игры: ' . $idGameNumber . '</br>';
    echo 'Номер хода: ' . $idMove_number . '</br>';
}

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
////////Извлечение данных из баз.//////////////////////////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

//Запрос к таблице Game

//$gameInfo = XDB::I()->FetchDataRow("SELECT * FROM game WHERE (gm_player1_id=@id OR gm_player2_id=@id) AND gm_winner<1 AND", array('id' => $user_aut));
$gameInfo = XDB::I()->FetchCollection("SELECT * FROM game WHERE gm_id=@idgame AND (gm_player1_id=@id OR gm_player2_id=@id) AND gm_winner<1", array('idgame' => $idGameEnter, 'id' => $user_aut));

//print_r($gameInfo);

$gameNumber = $gameInfo[0]['gm_id'];
$gmSymbol1 = $gameInfo[0]['gm_symbol1'];
$gmSymbol2 = $gameInfo[0]['gm_symbol2'];
$player1 = $gameInfo[0]['gm_player1_id'];
$player2 = $gameInfo[0]['gm_player2_id'];
echo '<br/>';
echo 'Номер игры: ' . $gameNumber;
echo '</br>';
echo 'Ид Первого игрока: ' . $player1;
echo '</br>';
echo 'Ид Второго игрока: ' . $player2;
echo '</br>';

$moveInfo = XDB::I()->FetchCollection("SELECT * FROM move WHERE mv_game_id=@id", array('id' => $gameNumber));

//Определение хода

$move_number = count($moveInfo);
echo 'Число ходов: ' . $move_number . '</br>';
echo '</br>';

//Информация хода

if($move_number % 2 == 0)
{
	echo 'Ход крестиков,нолики ожидайте.';
	echo '</br>';
}
else
{   
	echo 'Ход ноликов,крестики ожидайте.';
	echo '</br>';
}

//Смена хода
if($gmSymbol1 == 'X')
{
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
}

if($gmSymbol1 == 'O')
{
if($move_number % 2 == 0)
{
	$playerMain = $player2;
	$mainSymbol = $gmSymbol2;
}
else
{   
    if($move_number % 2 != 0)
	{
    $playerMain = $player1;
	$mainSymbol = $gmSymbol1;
	}
}	
}

if(!empty($_SESSION['USER']))
{
echo '<a href="field.php?exit=1">Выход</a><br />';
}

echo '</br>';


//Формирование заполненных ячеек поля
if($gmSymbol1 == 'X')
{
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
}
}

if($gmSymbol1 == 'O')
{
for($i = 0;$i < $move_number;$i++)
{
	if($i % 2 != 0)
{
	$mainSymbol = $gmSymbol1;
}
else
{   
	$mainSymbol = $gmSymbol2;
}
$celly = $moveInfo[$i]['mv_celly'];
$cellx = $moveInfo[$i]['mv_cellx'];
$gameMassive['cells'][$celly][$cellx] = $mainSymbol;
}
}

//Размеры поля
$sizeY = 3;
$sizeX = 3;


////////////////////////////////////
//////////////ФУНКЦИИ///////////////
////////////////////////////////////


//Функция отображения победителя

function champ($countIf, $playerSymbol)
{ 
  global $gameNumber, $player1, $player2, $gameMassive;
  if($countIf == 1)
  {
    if($playerSymbol == 'X')
    {
	  $gameMassive['win'] = 1;
    }
    else
      {
	    if($playerSymbol == 'O')
	    {
		  $gameMassive['win'] = 2;
	    }		
      }
  }
  if($gameMassive['win'] == 1)
{
	 XDB::I()->Update('game', $gameNumber, array('gm_winner' => $player1), 'gm_id');
}
else
{
	if($gameMassive['win'] == 2)
	{
		XDB::I()->Update('game', $gameNumber, array('gm_winner' => $player2), 'gm_id');
	}
}
}

//Забиваем в базу победителя

if($gameMassive['win'] == 1)
{
	 XDB::I()->Update('game', $gameNumber, array('gm_winner' => $player1), 'gm_id');
}
else
{
	if($gameMassive['win'] == 2)
	{
		XDB::I()->Update('game', $gameNumber, array('gm_winner' => $player2), 'gm_id');
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
   $row = $gameMassive['cells'][$y];
   list($allCellsSame, $photo) = isArraySolid($row, $sizeX);
   champ($allCellsSame, $photo);
}


//Проверка По вертикали
for($x = 0; $x < $sizeX; $x++)
{
	for($y = 0; $y < $sizeY; $y++)
    {
	$promMass[$y] = $gameMassive['cells'][$y][$x];
    }
	list($allCellsSame, $photo) = isArraySolid($promMass, $sizeX);
	champ($allCellsSame, $photo);
}

//Проверка по диагонали слева направо

	for($x = 0;$x < $sizeX;$x++)
	{
		$y = $x;
		$promMass[$y] = $gameMassive['cells'][$y][$x];
	}
	list($allCellsSame, $photo) = isArraySolid($promMass, $sizeX);
    champ($allCellsSame, $photo);

//Проверка диагонали справа налево
$x = ($sizeX - 1);
    for($y = 0;$y < $sizeY;$y++)
	{
		$promMass[$y] = $gameMassive['cells'][$y][$x];
		$x--;
	}
	list($allCellsSame, $photo) = isArraySolid($promMass, $sizeX);
    champ($allCellsSame, $photo);
	
//Определитель победителя

$gameInfo = XDB::I()->FetchDataRow("SELECT * FROM game WHERE gm_id=@id", array('id' => $gameNumber));
$winner = $gameInfo['gm_winner'];

if((!empty($winner)) && ($winner == $player1))
{
	echo 'Крестики победили!!!';
}
else if((!empty($winner)) && ($winner != $player1))
{
	echo 'Нолики победили!';
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
        if(empty($gameMassive['cells'][$y][$x]) && ($playerMain == $user_aut) && (empty($gameInfo['gm_winner'])))
        {
            echo '<a href="Field.php?idplayer=' . $playerMain . '&idcelly=' . $y . '&idcellx=' . $x . '&idgame=' . $gameNumber . '&idhod=' . ($move_number + 1) . '&push=1"><div style="width:30px; height:30px; background-color:green;"></div></a>';
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