<?php
jimport('joomla.application.component.view');

class ProjectManViewDetails extends JView
{
	public function display($tpl = null)
	{
// 		$items = $this->get('items');
// 		var_dump($items);
$input = new JInput;

		$this->items = $this->get('items');
		$this->id = $input->get('id', 0, 'int');
		
		if( ! $this->id)
		{
			echo 'Missing ID :(';
			
			return;
		}
// 		var_dump($this->items);
// 		$model = $this->getModel('Project');
		
// 		var_dump($model);
// 		$project = $model->load($this->id);
// 		var_dump($project);
// $table = JTable::getInstance('ProjectMan', 'Table');// $this->getTable();

// var_dump($table);
		parent::display($tpl);
	}//function

}//class
