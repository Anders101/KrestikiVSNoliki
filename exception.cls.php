<?

/*

XException v.1.0 (#1)

v.1.0 (#1), mb: Michael, date: Sun Oct 30 19:49:55 MSK 2005 
Файл создан

*/

if (!class_exists('Exception'))
{
	class Exception 
	{
		function __construct($a_Message)
		{
			
		}
	}	
}

/**
 * Базовый класс исключительных ситуаций
 *
 */
class XException extends Exception 
{
	/**
   * Сообщение, которое увидит обычный пользователь. Это сообщение не должно быть очень подробным 
	 и расскрывать особенности реализации. Оно должно лишь толково объяснить пользователю, что произошло 
		 *
	 * @var unknown_type
	 */
	private $m_UserMessage;
	
	/**
	 * Сообщение с техническими подробностями. Оно будет отображено в логах и будет показываться программистам
	 при работе в режиме отладки
	 *
	 * @var string 
	 */
	private $m_DetailedMessage;
	
	/**
	 * Конструктор
	 *
	 * @param string $a_UserMessage - сообщение для пользователя
	 * @param string $a_DetailedMessage - техническое сообщение
	 * @return XExeption
	 */
	function __construct($a_UserMessage, $a_DetailedMessage = null)
	{	
		parent::__construct($a_UserMessage);
		
		if ($a_DetailedMessage == null)
		{
			$a_DetailedMessage = $a_UserMessage;
		}		
		
		$this->m_UserMessage = $a_UserMessage;
		$this->m_DetailedMessage = $a_DetailedMessage;	
		
		
			
	}
	
	/**
	 * Получить сообщения для пользователя
	 *
	 * @return unknown
	 */
	function GetUserMessage ()
	{
		return $this->m_UserMessage;	
	}
	
	/**
	 * Получить техническое сообщение
	 *
	 * @return unknown
	 */
	function GetDetailedMessage ()
	{
		return $this->m_DetailedMessage;	
	}	
	
	public function ThrowMe ()
	{
		echo $this->m_UserMessage;
		die();
	}
}

class XInnerSecurityException extends XException 
{
	function __construct($a_Description)
	{
		parent::__construct('Внутренняя ошибка безопасности', $a_Description);	
	}	
}

class XInnerException extends XException 
{
	function __construct($a_Description)
	{
		parent::__construct('Произошла внутренняя ошибка системы', $a_Description);	
	}	
}

class XUserException extends XException 
{
	function __construct($a_Description)
	{
		parent::__construct($a_Description, $a_Description);	
	}	
}

