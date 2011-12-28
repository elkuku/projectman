<?php
jimport('joomla.application.component.view');

class ProjectManViewProjectMan extends JView
{
	public function display($tpl = null)
	{
// 		$items = $this->get('items');
// 		var_dump($items);
		$this->list = $this->get('items');
// $table = JTable::getInstance('ProjectMan', 'Table');// $this->getTable();

// var_dump($table);
		parent::display($tpl);
	}//function

}//class
