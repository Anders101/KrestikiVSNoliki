<?

/*

XException v.1.0 (#1)

v.1.0 (#1), mb: Michael, date: Sun Oct 30 19:49:55 MSK 2005 
���� ������

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
 * ������� ����� �������������� ��������
 *
 */
class XException extends Exception 
{
	/**
   * ���������, ������� ������ ������� ������������. ��� ��������� �� ������ ���� ����� ��������� 
	 � ����������� ����������� ����������. ��� ������ ���� ������� ��������� ������������, ��� ��������� 
		 *
	 * @var unknown_type
	 */
	private $m_UserMessage;
	
	/**
	 * ��������� � ������������ �������������. ��� ����� ���������� � ����� � ����� ������������ �������������
	 ��� ������ � ������ �������
	 *
	 * @var string 
	 */
	private $m_DetailedMessage;
	
	/**
	 * �����������
	 *
	 * @param string $a_UserMessage - ��������� ��� ������������
	 * @param string $a_DetailedMessage - ����������� ���������
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
	 * �������� ��������� ��� ������������
	 *
	 * @return unknown
	 */
	function GetUserMessage ()
	{
		return $this->m_UserMessage;	
	}
	
	/**
	 * �������� ����������� ���������
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
		parent::__construct('���������� ������ ������������', $a_Description);	
	}	
}

class XInnerException extends XException 
{
	function __construct($a_Description)
	{
		parent::__construct('��������� ���������� ������ �������', $a_Description);	
	}	
}

class XUserException extends XException 
{
	function __construct($a_Description)
	{
		parent::__construct($a_Description, $a_Description);	
	}	
}

