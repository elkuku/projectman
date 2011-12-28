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

}//class
