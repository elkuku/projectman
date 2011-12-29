<?php
jimport('joomla.application.component.modellist');

class ProjectManModelDetails extends JModelList
{
    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->db = $this->_db; //@todo deprecate soonish..
    }//function

    protected function getListQuery()
    {
        $query = $this->db->getQuery(true);

        $query->from('#__projects_items AS pi');
        $query->leftJoin('#__projects AS p ON pi.project_id = p.id');
        $query->select('pi.*, p.url');

        $input = new JInput;

        $id = $input->get('id', 0, 'int');

        if(!$id)
            throw new Exception(__METHOD__.' - Invalid project');

        $query->where('project_id='.$id);

        return $query;
    }//function

    public function refresh($item)
    {
        $path = $item->path;

        if(!is_dir($item->path))
            throw new Exception('Invalid path');

        $query = $this->db->getQuery(true);

        $query->from('#__projects_items');
        $query->where('project_id='.(int)$item->id);
        $query->delete();

        $this->db->setQuery($query)->query();

        $excludes = explode(',', (string)$item->excludes);

        $table = $this->getTable();

        foreach(new DirectoryIterator($item->path) as $fileInfo)
        {
            $name = $fileInfo->getFilename();

            if($fileInfo->isDot()
                || !$fileInfo->isDir()
                || in_array($name, $excludes)
                || 0 === strpos($name, '.')
            )
                continue;

            $table->reset();

            $table->id = null;
            $table->project_id = $item->id;
            $table->folder = $name;

            if(is_dir($fileInfo->getPathname().'/.git'))
            {
                $table->vcs = 'git';
                $table->branches = shell_exec('cd '.$fileInfo->getPathname().' && git branch');
                $table->status = shell_exec('cd '.$fileInfo->getPathname().' && git status');
            }

            if(is_dir($fileInfo->getPathname().'/administrator'))
            {
                //-- We assume Joomla!
                $table->isjoomla = 1;
            }

            $table->store();
        }//foreach
    }//function

}//class
