<?php
/**
 * Configuration class.
 */

defined('_JEXEC') or die;

/**
 * CLI configuration class.
 */
final class JConfig
{
	/**
	 * The application theme.
	 *
	 * @var    string
	 */
	public $theme = 'projectman';

	/**
	 * Database infos
	 */
	public $dbtype = 'sqlite';
	public $db = 'projectman.sdb';
	public $dbprefix = 'pjman_';

}//class
