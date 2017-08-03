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
    $_SESSION['USERI'] = $_POST['playerid'];
	}
	else
	{	
	  echo 'Ваш id не зарегестрирован,попробуйте снова.</br>';
	}
}

if(!empty($_GET['exit']))
{
	$_SESSION['USERI'] = array();
}


if(!empty($_SESSION['USERI']))
{
	$userAut = $_SESSION['USERI'];
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


if(!empty($_POST['namereg']))
{
$userNameR = $_POST['name'];
$result = XDB::I()->Insert('playerreg', array (
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
       <p>Ваше имя: <input type="text" name="namereg" /></p>
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

if(!empty($_SESSION['USERI']))
{
echo '<br/>';
echo '<a href="index.php?creategame=1">Новая игра</a>';
echo '<br/>';
}
if(!empty($_SESSION['USERI']))
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
$symbol = $_POST['symbol'];

if(!empty($_POST['playeridcr']))
{
$result = XDB::I()->Insert('game', array (
'gm_player1_id' => $playeridcr,
'gm_symbol1' => $symbol
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
$gameInfo = XDB::I()->FetchCollection("SELECT * FROM game WHERE (gm_player1_id=@id OR gm_player2_id=@id) AND gm_winner<1", array('id' => $searchGame));
if(empty($gameInfo))
{
	echo 'Запрос вернул пустой результат.<br/>';
}


if(!empty($_GET['searchgame']))
{
$gameArray = count($gameInfo);
echo 'Найдено доступных для подключения игр: ' . $gameArray;
echo '<br/>';
if(!empty($userAut))
{
	for($x = 0; $x < $gameArray; $x++)
	{
		$gameInfo = XDB::I()->FetchCollection("SELECT * FROM game WHERE (gm_player1_id=@id OR gm_player2_id=@id) AND gm_winner<1", array('id' => $searchGame));
		$idPassGame = $gameInfo[$x]['gm_id'];
		echo 'Id игры: ' . $idPassGame;
		echo '<br/>';
	}
}
echo '<br/>';
echo 'Чтобы присоединиться к игре разлогинтесь,перейдите по ссылке и используйте один из предложенных id';
echo '<br/>';
echo '<a href="field.php">На поле</a>';
}


?>