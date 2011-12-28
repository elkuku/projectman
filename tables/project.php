<?php
class TableProject extends JTable
{
	function __construct($db)
	{
		parent::__construct('#__projects', 'id', $db);
	}//function

}//class
