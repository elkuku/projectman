<?php

jimport('joomla.application.component.modellist');

class ProjectManModelProjectMan extends JModelList
{
	public function __construct($config = array())
	{
		parent::__construct($config);

		$this->db = $this->_db;//@todo deprecate soonish..
	}//function

	protected function getListQuery()
	{
		$query = $this->db->getQuery(true);

		$query->from('#__projects AS p');
		$query->select('p.*');

		return $query;
	}//function

	public function getList()
	{
		$list = array();

		foreach($this->getItems() as $project)
		{
			$excludes = explode(',', (string)$project->excludes);

			if( ! JFolder::exists($project->path))
			{
				JFactory::getApplication()->enqueueMessage('Invalid project dir: '.$project->path, 'error');

				continue;
			}

			$p = new ProjectManProjectLoc($project->path, $project->url);

			foreach (new DirectoryIterator($project->path) as $fileInfo)
			{
				if($fileInfo->isDot()
				|| ! $fileInfo->isDir()
				|| in_array($fileInfo->getFilename(), $excludes)
				|| 0 === strpos($fileInfo->getFilename(), '.'))
				continue;

				$p->addProject($fileInfo->getFilename());
			}//foreach

			$list[] = $p;
		}//foreach

		return $list;
	}//function

	public function getTable($type = 'ProjectMan', $prefix = 'Table', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}//function

}//class

class ProjectManProjectLoc
{
	public $path;
	public $url;

	public $projects = array();

	public function __construct($path, $url)
	{
		$this->path = $path;
		$this->url = $url;
	}//function

	public function addProject($folder)
	{
		$path = $this->path.'/'.$folder;

		if( ! JFolder::exists($path))
		throw new Exception(__METHOD__.' - Invalid Path: '.$path);

		$this->projects[] = new ProjectManProject($folder);
	}//function

}//class

class ProjectManProject
{
	public $folder = '';
	public $isJoomla = false;

	public function __construct($folder)
	{
		$this->folder = $folder;
	}//function

}//class
