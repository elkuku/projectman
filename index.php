<?php
/**
 * ProjectMan
 *
 * A JApplicationWeb Joomla! web application built on the Joomla! Platform.
 *
 * @author 2011 Nikolai Plath - elkuku
 *
 * @license GNU GPL
 */

//-- We are a valid Joomla! entry point.
define('_JEXEC', 1);

//-- Setup the base path related constant(S).
define('JPATH_BASE', __DIR__);

define('JPATH_SITE', JPATH_BASE);
define('JPATH_COMPONENT', JPATH_BASE);
define('JPATH_CACHE', JPATH_BASE);

//-- Required for JModels way to find table classes :|
define('JPATH_COMPONENT_ADMINISTRATOR', JPATH_BASE);

//-- Our "template" directory
define('JPATH_THEMES', JPATH_BASE.'/themes');

//-- Increase error reporting to that ***ANY*** errors are displayed.
error_reporting(-1);
ini_set('display_errors', true);

//-- Bootstrap the application.
require $_SERVER['JOOMLA_PLATFORM_PATH'].'/libraries/import.php';

//-- Import the JApplicationWeb class from the platform.
jimport('joomla.application.web');
jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');

//-- Set error handler to echo - @todo remove when JError is finally dead :P
JError::setErrorHandling(E_ERROR, 'echo');
JError::$legacy = false;

//-- Include custom SQLite driver
require 'dbdriver/sqlite.php';

/**
 * A lil project manager.
 */
class ProjectMan extends JApplicationWeb
{
	private $messageQueue = array();

	/**
	 * Execute Me.
	 */
	protected function doExecute()
	{
		$this->setUpDB();

// 		$controller = JController::getInstance('Projectman');

		//-- Start an output buffer.
		ob_start();

		JController::getInstance('Projectman')->execute($this->input->get('task', '', 'cmd'));

		//-- Get the buffer output.
		$output = ob_get_clean();

		//-- Push the output into the document buffer.
		$this->document->setBuffer($output, array('type' => 'component', 'name' => 'main'));

		$this->document->setTitle('ProjectMan by =;)');
	}//function

	/**
	 * Set up our custom database - @todo move - to a model ?
	 *
	 * @throws Exception
	 */
	protected function setUpDB()
	{
		$config = JFactory::getConfig();

		$path = JPATH_BASE.'/db/'.$config->get('db');

		if(JFile::exists($path))
		return $this;

		JFolder::create(JPATH_BASE.'/db');

		$db = JDatabase::getInstance(array(
				'driver' => $config->get('dbtype'),
				'database' => $config->get('db'),
				'prefix' => $config->get('dbprefix'),
				'create_db' => true,
		));

		$sql = JFile::read(JPATH_BASE.'/install/projectman.sql');

		$queries = $db->splitSql($sql);

		foreach ($queries as $query)
		{
			if( ! trim($query))
			continue;

			if( ! $db->setQuery($query)->query())
			{
				//@todo Mrs. $db - please throw your exceptions yourself :P
				$a = $db->errorInfo();
				$b = $db->errorCode();

				throw new Exception(sprintf('Database error(%s): %s)',$a[0], $a[2]), 666);
			}
		}//foreach

		return $this;
	}//function



	/**
	* Method to get the template name. This is needed for compatability with JApplication.
	*
	* @return  string  The theme name.
	*/
	public function getTemplate()
	{
		return $this->get('theme');
	}//function

	/**
	 * Method to get a menu... This is needed for compatability with JApplication.
	 *
	 * @return  null.
	 */
	public function getMenu()
	{
		return null;
	}//function

	/**
	* Gets the value of a user state variable.
	*
	* @param   string  $key      The key of the user state variable.
	* @param   string  $request  The name of the variable passed in a request.
	* @param   string  $default  The default value for the variable if not found. Optional.
	* @param   string  $type     Filter for the variable, for valid values see {@link JFilterInput::clean()}. Optional.
	*
	* @return  The request user state.
	*/
	public function getUserStateFromRequest($key, $request, $default = null, $type = 'none')
	{
		$cur_state = $this->getUserState($key, $default);
		$new_state = JRequest::getVar($request, null, 'default', $type);

		// Save the new value only if it was set in this request.
		if ($new_state !== null)
		{
			$this->setUserState($key, $new_state);
		}
		else
		{
			$new_state = $cur_state;
		}

		return $new_state;
	}

	/**
	 * Gets a user state.
	 *
	 * @param   string  $key      The path of the state.
	 * @param   mixed   $default  Optional default value, returned if the internal value is null.
	 *
	 * @return  mixed  The user state or null.
	 */
	public function getUserState($key, $default = null)
	{
		$session = JFactory::getSession();
		$registry = $session->get('registry');

		if (!is_null($registry))
		{
			return $registry->get($key, $default);
		}

		return $default;
	}

	/**
	 * Sets the value of a user state variable.
	 *
	 * @param   string  $key    The path of the state.
	 * @param   string  $value  The value of the variable.
	 *
	 * @return  mixed  The previous state, if one existed.
	 *
	 * @since   11.1
	 */
	public function setUserState($key, $value)
	{
		$session = JFactory::getSession();
		$registry = $session->get('registry');

		if (!is_null($registry))
		{
			return $registry->set($key, $value);
		}

		return null;
	}

	/**
	 * Gets a configuration value.
	 *
	 * An example is in application/japplication-getcfg.php Getting a configuration
	 *
	 * @param   string  $varname  The name of the value to get.
	 * @param   string  $default  Default value to return
	 *
	 * @return  mixed  The user state.
	 */
	public function getCfg($varname, $default = null)
	{
		return $this->config->get((string)$varname, $default);
	}

	/**
	* Enqueue a system message.
	*
	* @param   string  $msg   The message to enqueue.
	* @param   string  $type  The message type. Default is message.
	*
	* @return  void
	*
	* @since   11.1
	*/
	public function enqueueMessage($msg, $type = 'message')
	{
		// For empty queue, if messages exists in the session, enqueue them first.
		if (!count($this->messageQueue))
		{
			$session = JFactory::getSession();
			$sessionQueue = $session->get('application.queue');

			if (count($sessionQueue))
			{
				$this->messageQueue = $sessionQueue;
				$session->set('application.queue', null);
			}
		}

		// Enqueue the message.
		$this->messageQueue[] = array('message' => $msg, 'type' => strtolower($type));
	}

	/**
	* Get the system message queue.
	*
	* @return  array  The system message queue.
	*
	* @since   11.1
	*/
	public function getMessageQueue()
	{
		// For empty queue, if messages exists in the session, enqueue them.
		if (!count($this->messageQueue))
		{
			$session = JFactory::getSession();
			$sessionQueue = $session->get('application.queue');

			if (count($sessionQueue))
			{
				$this->messageQueue = $sessionQueue;
				$session->set('application.queue', null);
			}
		}

		return $this->messageQueue;
	}



}//class

if( ! class_exists('JComponentHelper'))
{
	class JComponentHelper
	{
		public static function getParams() 
		{
			//-- I am just a dummy :|
			return new JRegistry;
		}
	}
}

try
{
	//-- Instantiate the application.
	$application = JWeb::getInstance('ProjectMan');

	//-- Initialise the application.
	$application->initialise();

	//-- Store the application.
	JFactory::$application = $application;

	//-- Execute the application.
	$application->execute();

}//try
catch (Exception $e)
{
	echo '<h2 style="color: red">'.$e->getMessage().'</h2>';
	echo '<pre>'.$e->getTraceAsString().'</pre>';

	exit($e->getCode());
}//catch
