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

/**
 * Auto79 helper.
 *
 * @since  1.6
 */
class Auto79Helper {

    /**
     * Configure the Linkbar.
     *
     * @param   string  $vName  string
     *
     * @return void
     */
    public static function addSubmenu($vName = '') {
        JHtmlSidebar::addEntry(
                JText::_('COM_AUTO79_TITLE_ARTICLESS'), 'index.php?option=com_auto79&view=articless', $vName == 'articless'
        );
//        JHtmlSidebar::addEntry(
//                JText::_('COM_AUTO79_TITLE_LINKS'), 'index.php?option=com_auto79&view=links', $vName == 'links'
//        );
        JHtmlSidebar::addEntry(
                JText::_('COM_AUTO79_TITLE_CRONS'), 'index.php?option=com_auto79&view=crons', $vName == 'crons'
        );
    }

    /**
     * Gets the files attached to an item
     *
     * @param   int     $pk     The item's id
     *
     * @param   string  $table  The table's name
     *
     * @param   string  $field  The field's name
     *
     * @return  array  The files
     */
    public static function getFiles($pk, $table, $field) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
                ->select($field)
                ->from($table)
                ->where('id = ' . (int) $pk);

        $db->setQuery($query);

        return explode(',', $db->loadResult());
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return    JObject
     *
     * @since    1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_auto79';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

    public static function formatDate($date, $format = 'd/m/Y') {
        if ($date == '0000-00-00' || $date == '' || $date === '0000-00-00 00:00:00') {
            return false;
        }
        if ($format == '' || $format == null) {
            $format = 'Y-m-d H:i:s';
        }
        $date = date_create($date);
        return date_format($date, $format);
    }

}
