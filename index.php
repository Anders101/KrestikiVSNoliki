<?
define('DBBASE', 'gamedata');
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', ''); 

session_start();

include 'db.cls.php';
include 'exception.cls.php';

echo 'Добро пожаловать на главную страницу Крестики-Нолики';
echo '<br/>';

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//Блок Регистрации-Авторизации
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////

//Авторизация

$userAut = $_POST['playerid'];

if(!empty($_POST['playerid']))
{
	$userInfo = XDB::I()->FetchDataRow("SELECT pl_name FROM player WHERE pl_id=@id", array('id' => $_POST['playerid']));
    if(!empty($userInfo))
    {		
    $_SESSION['USER'] = $_POST['playerid'];
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
	$userAut = $_SESSION['USER'];
	$userInfo = XDB::I()->FetchDataRow("SELECT pl_name FROM player WHERE pl_id=@id", array('id' => $userAut));
    $userName = $userInfo['pl_name'];
	echo 'Здравствуйте   ';
    echo $userName;	
    echo '</br>';
}
else
{
    echo   '<form action="index.php" method="post">
       <p>Ваш Id: <input type="text" name="playerid" /></p>
       <p><input type="submit" value="Войти"/></p>
       </form>';
}
echo '<a href="index.php?regist=1">Зарегистрироваться</a>';

//Регистрация


if(!empty($_POST['name']))
{
$userNameR = $_POST['name'];
$result = XDB::I()->Insert('player', array (
'pl_name' => $userNameR
)
);
}

if(!empty($userNameR))
{
	$playeridReg = XDB::I()->LastInsertId();
	echo 'Поздравляем вас: ' . $userNameR . ' с успешной регистрацией.Ваш Id: ' . $playeridReg . ' используйте его,чтобы авторизоваться.<br/>';
}
/*
if(!empty($userId
{
	echo 'Поздравляем вас: ' . $userNameR . ' с успешной регистрацией.Ваш Id: ' . $userId . ' используйте его,чтобы авторизоваться.<br/>';
}
*/

if(!empty($_GET['regist']))
{
echo   '<form action="index.php" method="post">
       <p>Ваше имя: <input type="text" name="name" /></p>
       <p><input type="submit" value="Зарегестрироваться"/></p>
       </form>';
echo '<br/>';


}
echo '<br/>';
	echo '<a href="index.php?exit=1">Выход</a><br />';
echo '<br/>';

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////

if(!empty($_SESSION['USER']))
{
echo '<br/>';
echo '<a href="index.php?creategame=1">Новая игра</a>';
echo '<br/>';
}

if(!empty($_SESSION['USER']))
{
echo '<br/>';
echo '<a href="index.php?searchgame=1">Поиск активных игр.</a>';
echo '<br/>';
}

//Создание Новой Игры
if(!empty($_GET['creategame']))
{
	echo   '<form action="index.php" method="post">
       <p>Ваш Id: <input type="text" name="playeridcr" /></p>
	   <p><input type="radio" name="symbol" value="X" checked>Играть X</p>
	   <p><input type="radio" name="symbol" value="O" >Играть O</p>
       <p><input type="submit" value="Создать Игру"/></p>
       </form>';
	echo '<br/>';
}

$playeridcr = $_POST['playeridcr'];
$symbolPlayer = $_POST['symbol'];
if($symbolPlayer == 'X')
{
	$secondSymbol = 'O';
}
else
{
	$secondSymbol = 'X';
}

if(!empty($_POST['playeridcr']))
{
$result = XDB::I()->Insert('game', array (
'gm_player1_id' => $playeridcr,
'gm_symbol1' => $symbolPlayer,
'gm_symbol2' => $secondSymbol
)
);
}

$idCreatedGame = XDB::I()->LastInsertId();
if(!empty($idCreatedGame))
{
echo 'Id созданной игры: ' . $idCreatedGame;
echo 'Игра создана,ожидайте подключения второго игрока.<br/>';
echo '<br/>';
echo '<a href="field.php">Перейти на игровое поле.</a>';
}

//Присоединение к игре

$searchGame = 0;
$gameInfo = XDB::I()->FetchCollection("SELECT * FROM game WHERE (gm_player1_id=@usid AND gm_player2_id=@id) AND gm_winner<1", array('usid' => $userAut, 'id' => $searchGame));

if(!empty($_GET['searchgame']))
{
$gameArray = count($gameInfo);
$gameInfo = XDB::I()->FetchCollection("SELECT * FROM game WHERE (gm_player1_id=@usid AND gm_player2_id=@id) AND gm_winner<1", array( 'usid' => $userAut, 'id' => $searchGame));
echo 'Созданные вами игры: ' . $gameArray;
echo '<br/>';
if(!empty($userAut))
{
	for($x = 0; $x < $gameArray; $x++)
	{
		$idPassGame = $gameInfo[$x]['gm_id'];
		echo 'Id игры: ' . $idPassGame;
		echo '<br/>';
	}
}
echo '<br/>';
echo 'Чтобы войти в игру разлогинтесь,перейдите по ссылке и используйте один из предложенных id';
echo '<br/>';
echo '<a href="field.php">На поле</a>';
}

if(!empty($_GET['searchgame']))
{
$gameInfo = XDB::I()->FetchCollection("SELECT * FROM game WHERE (gm_player1_id!=@usid AND gm_player2_id=@id) AND gm_winner<1", array('usid' => $userAut, 'id' => $searchGame));
$gameArray = count($gameInfo);
echo '<br/>';
echo '<br/>';
echo 'Доступные для подключения игры: ' . $gameArray;
echo '<br/>';
if(!empty($userAut))
{
	for($x = 0; $x < $gameArray; $x++)
	{
		if(empty($gameInfo))
		{
			echo 'Нет доступных игр для подключения';
			break;
		}
		$idPassGame = $gameInfo[$x]['gm_id'];
		echo 'Id игры: ' . $idPassGame;
		echo '<br/>';
	}
}
echo '<br/>';
echo 'Чтобы войти в игру разлогинтесь,перейдите по ссылке и используйте один из предложенных id';
echo '<br/>';
echo '<a href="index.php?enjoy=1">Присоединиться</a>';
}

if(!empty($_GET['enjoy']))
{
		echo   '<form action="index.php" method="post">
       <p>Id игры: <input type="text" name="gameidenjoy" /></p>
       <p><input type="submit" value="Присоединиться"/></p>
       </form>';
	echo '<br/>';
}

if(!empty($_POST['gameidenjoy']))
{
	$gameidenjoy = $_POST['gameidenjoy'];
	XDB::I()->Update('game', $gameidenjoy, array('gm_player2_id' => $userAut), 'gm_id');
}



?>