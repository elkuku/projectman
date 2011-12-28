<?php
jimport('joomla.application.component.view');

class ProjectManViewProject extends JView
{
	public function display($tpl = null)
	{
		$this->item = $this->get('Item');

		if(false == $this->item)
		throw new Exception('Invalid item');

		parent::display($tpl);
	}//function

}//class
