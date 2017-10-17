<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Auto79
 * @author     Thang Tran Trong <trantrongthang1207@gmail.com>
 * @copyright  2017 Thang Tran Trong
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Job controller class.
 *
 * @since  1.6
 */
class Auto79ControllerJob extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'jobs';
		parent::__construct();
	}
}
