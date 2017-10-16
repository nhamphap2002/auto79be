<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Auto79
 * @author     Thang Tran <trantrongthang1207@gmail.com>
 * @copyright  2017 Thang Tran
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Element controller class.
 *
 * @since  1.6
 */
class Auto79ControllerElement extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'elements';
		parent::__construct();
	}
}
