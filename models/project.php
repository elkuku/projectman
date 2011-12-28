<?php
jimport('joomla.application.component.modeladmin');

/**
 * Banner model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_banners
 * @since		1.6
 */
class ProjectManModelProject extends JModelAdmin
{
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_projectman.project', 'project', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	public function save($data)
	{
		$table = $this->getTable();
		$key = $table->getKeyName();

		$pk = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
		$isNew = true;

		if(0 === $data[$key])
		$data[$key] = null;

		if($pk > 0)
		{
			$table->load($pk);
			$isNew = false;
		}

		// Bind the data.
		if( ! $table->bind($data))
		throw new Exception($table->getError());

		// Prepare the row for saving
		$this->prepareTable($table);

		// Check the data.
		if( ! $table->check())
		throw new Exception($table->getError());

		// Store the data.
		if( ! $table->store())
		throw new Exception($table->getError());

		$pkName = $table->getKeyName();

		if (isset($table->$pkName))
		{
			$this->setState($this->getName() . '.id', $table->$pkName);
		}
		
		$this->setState($this->getName() . '.new', $isNew);

		return true;
	}
	/**
	 * Method to delete one or more records.
	 *
	 * @param   array  &$pks  An array of record primary keys.
	 *
	 * @return  boolean  True if successful, false if an error occurs.
	 *
	 * @since   11.1
	 */
	public function delete(&$pks)
	{
		// Initialise variables.
		$pks = (array) $pks;
		$table = $this->getTable();

		// Iterate the items to delete each one.
		foreach ($pks as $pk)
		{
			if($table->load($pk))
			{
				if( ! $table->delete($pk))
				{
					$this->setError($table->getError());
					return false;
				}
			}
			else
			{
				$this->setError($table->getError());
				return false;
			}
		}//foreach

		return true;
	}//function

}//class
