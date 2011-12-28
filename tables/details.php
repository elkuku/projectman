<?php
class TableDetails extends JTable
{
	function __construct($db)
	{
		parent::__construct('#__projects_items', 'id', $db);
	}//function

}//class
