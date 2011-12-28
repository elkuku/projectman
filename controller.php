<?php
class ProjectManController extends JController
{
	public function display($cachable = false, $urlparams = false)
	{
		parent::display($cachable, $urlparams);
	}

	public function save()
	{
		$model = $this->getModel('Project');

		$input = new JInput;

		$data = array();
		$data['id'] = $input->get('id', null, 'int');
		$data['path'] = $input->get('path', '', 'html');
		$data['url'] = $input->get('url', '', 'html');

		if(empty($data['path']))
		{
			JFactory::getApplication()->enqueueMessage('Project path must not be empty', 'error');

			JRequest::setVar('view', 'project');//@todo deprecate
		}
		else
		{
			$model->save($data);

			JFactory::getApplication()->enqueueMessage('Your project has been saved');
		}

		parent::display();
	}
	
	public function delete() 
	{
		$input = new JInput;
		
		$id = $input->get('id', 0, 'int');
		
		if( ! $id)
		throw new Exception(__METHOD__.' - Empty id');
		
		$model = $this->getModel('Project');
		
		if( ! $model->delete($id))
		{
			JFactory::getApplication()->enqueueMessage($model->getError(), 'error');;
		}
		else
		{
			JFactory::getApplication()->enqueueMessage('Your project has been deleted');
		}
		
		parent::display();
	}
	
	public function refresh() 
	{
		$input = new JInput;

		$model = $this->getModel('Details');
		
		$id = $input->get('id', 0, 'int');
		
		$projectModel = $this->getModel('Project');
		
		$item = $projectModel->getItem();
		
// 		var_dump($item);

		$model->refresh($item);
		
		parent::display();
	}

}//class
