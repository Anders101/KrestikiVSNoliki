<?
//Инфо базы данных

define('DBBASE', 'gamedata');
define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', ''); 

session_start();

//Подключение классов

include 'db.cls.php';
include 'exception.cls.php';

echo 'Добро пожаловать на главную страницу Крестики-Нолики';
echo '<br/>';
echo '<br/>';
echo '<br/>';

/////////////////////////////////////////////////////////////////////////////////////////
//Технический блок

//Авторизация
$user_aut = $_POST['name'];

//Регистрация
if(!empty($_POST['namereg']))
    {
        $userNameR = $_POST['namereg'];
        $result = XDB::I()->Insert('player', array (
        'pl_name' => $userNameR
        )
        );
	$playeridReg = XDB::I()->LastInsertId();
	$_SESSION['USER'] = $playeridReg;
    }

//Авторизация определение ИД игрока
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

//Выход
if(!empty($_GET['exit']))
    {
	$_SESSION['USER'] = array();
    }

//Приветствие игрока
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

//Создание новой игры

$playeridcr = $_SESSION['USER'];
$symbolPlayer = $_POST['symbol'];
if($symbolPlayer == 'X')
    {
	$secondSymbol = 'O';
    }
    else
    {
	$secondSymbol = 'X';
    }

if(!empty($_POST['yes']))
    {
        $result = XDB::I()->Insert('game', array (
        'gm_player1_id' => $playeridcr,
        'gm_symbol1' => $symbolPlayer,
        'gm_symbol2' => $secondSymbol
        )
        );
    $idCreatedGame = XDB::I()->LastInsertId();
    }
	
//Поиск доступных игр
if(!empty($_GET['searchgame']))
    {
        $gameInfo = XDB::I()->FetchCollection("SELECT * FROM game WHERE (gm_player1_id!=@usid AND gm_player2_id=@id) AND gm_winner<1", array('usid' => $userAut, 'id' => $searchGame));    
	    $gameArray = count($gameInfo);
    }
	
//Подключение к игре
if(!empty($_GET['enjoy']))
    {
	    $idGameEn = $_GET['idgameen'];
	    $idPlayerEn = $_SESSION['USER'];
	    echo '<br/>';
	    echo $idGameEn;
	    echo '<br/>';
	    echo $idPlayerEn;
	    XDB::I()->Update('game', $idGameEn, array('gm_player2_id' => $idPlayerEn), 'gm_id');
    }

//Проверка уже запущеных игр с двумя игроками
if((!empty($_SESSION['USER'])) && (!empty($_GET['searchgame'])))
    {
        $gameInfo = XDB::I()->FetchCollection("SELECT * FROM game WHERE (gm_player1_id=@usid || gm_player2_id=@usid) AND gm_winner<1", array('usid' => $_SESSION['USER']));
        $gameArray = count($gameInfo);
        echo '<br/>';
        echo 'Активные игры к которым вы подключены: ' . $gameArray;
        echo '<br/>';
    }

if(!empty($_SESSION['USER']))
{
	for($x = 0; $x < $gameArray; $x++)
	{
		$idPassGame = $gameInfo[$x]['gm_id'];
		echo 'Id игры: ' . $idPassGame . ' Ид соперника: ' . $idFirstPlayer . ' Ваш символ: ' . $symbolSecondPlayer . '<a href="field.php?idgame=' . $idPassGame . '"> Войти в игру.</a>';
		echo '<br/>';
	}
}

//Проверка уже запущеных игр с двумя игроками
if((!empty($_SESSION['USER'])) && (!empty($_GET['searchgame'])))
    {
        $gameInfo = XDB::I()->FetchCollection("SELECT * FROM game WHERE (gm_player1_id!=@usid && gm_player2_id=0) AND gm_winner<1", array('usid' => $_SESSION['USER']));
        $gameArray = count($gameInfo);

    }

/////////////////////////////////////////////////////////
//Блок отображения 

//Вход
if((empty($_SESSION['USER'])) && (empty($_GET['regist'])))
    {
	    echo   '<form action="index2.php" method="post">
        Ваш id: <input type="text" name="name" />
        <input type="submit" value="Войти"/>
        </form>';
    }
	

if(empty($_SESSION['USER']) &&(empty($_GET['regist'])))
    {
	    echo '<a href="index2.php?regist=1">Зарегистрироваться</a>';
    }

//Вывод сообщения об успешной регистрации
if(!empty($userNameR))
    {
	    echo '<br/>';
	    echo 'Поздравляем вас: ' . $userNameR . ' с успешной регистрацией.Ваш Id: ' . $playeridReg . ' используйте его,чтобы авторизоваться.<br/>';
    }

//Вывод формы регистрации
if(!empty($_GET['regist']))
    {
        echo   '<form action="index2.php" method="post">
        Ваше имя: <input type="text" name="namereg" />
        <input type="submit" value="Зарегестрироваться"/>
        </form>';
	    echo '<a href="index2.php">Отмена</a>';
	    echo '<br/>';
    }

if(!empty($_SESSION['USER']))
    {
        echo '<a href="index2.php?creategame=1">Создать игру</a>';
        echo '<br/>';
    }

//Создание Новой Игры
if(!empty($_GET['creategame']))
    {
	    echo   '<form action="index2.php" method="post">
	    <p><input type="radio" name="symbol" value="X" checked>Играть X</p>
	    <p><input type="radio" name="symbol" value="O" >Играть O</p>
	    <p><input type="hidden" name="yes" value="1" ></p>
        <p><input type="submit" value="Создать Игру"/></p>
        </form>';
	    echo '<a href="index2.php">Отмена</a>';
	    echo '<br/>';
    }

//Отображение созданной игры
if(!empty($idCreatedGame))
    {
        echo 'Игра создана!<br/>';
        echo '<br/>';
        echo 'Id созданной игры: ' . $idCreatedGame;
        echo '<br/>';
        echo '<a href="field.php?idgame=' . $idCreatedGame . '">Перейти на игровое поле.</a>';
    }

if(!empty($_SESSION['USER']))
    {
        echo '<br/>';
        echo '<a href="index2.php?searchgame=1">Поиск активных игр.</a>';
        echo '<br/>';
    }

//Отображение активных игр к которым можно подключиться

if((!empty($_SESSION['USER'])) && (!empty($_GET['searchgame'])))
    {
	    echo '<br/>';
        echo 'Доступные для подключения игры: ' . $gameArray;
        echo '<br/>';
	    for($x = 0; $x < $gameArray; $x++)
	    {
	    	$idPassGame = $gameInfo[$x]['gm_id'];
			$idFirstPlayer = $gameInfo[$x]['gm_player1_id'];
			$symbolSecondPlayer = $gameInfo[$x]['gm_symbol2'];
		    echo 'Id игры: ' . $idPassGame . ' Ид соперника: ' . $idFirstPlayer . ' Доступный символ: ' . $symbolSecondPlayer . '<a href="index2.php?idgameen=' . $idPassGame . '&enjoy=1"> Подключиться </a>';
			echo '<br/>';
		}
		echo '<br/>';
		echo '<a href="index2.php">Отмена</a>';
	    echo '<br/>';
    }

if(!empty($_SESSION['USER']))
    {
	    echo '<a href="index2.php?exit=1">Выход</a><br />';
	    exit;
    }


?>