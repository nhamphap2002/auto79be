<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Auto79
 * @author     Thang Tran <trantrongthang1207@gmail.com>
 * @copyright  2017 Thang Tran
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Auto79 records.
 *
 * @since  1.6
 */
class Auto79ModelArticless extends JModelList {

    /**
     * Constructor.
     *
     * @param   array  $config  An optional associative array of configuration settings.
     *
     * @see        JController
     * @since      1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.`id`',
                'ordering', 'a.`ordering`',
                'state', 'a.`state`',
                'created_by', 'a.`created_by`',
                'modified_by', 'a.`modified_by`',
                'link', 'a.`link`',
                'category_id', 'a.`category_id`',
                'province', 'a.`province`',
                'approval', 'a.`approval`',
                'timeapproval', 'a.`timeapproval`',
                'hasget', 'a.`hasget`',
                'hasapproval', 'a.`hasapproval`',
                'time_created', 'a.`time_created`',
                'cronid', 'a.`cronid`',
                'postid', 'a.`postid`',
                'user_approval', 'a.`user_approval`',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @param   string  $ordering   Elements order
     * @param   string  $direction  Order direction
     *
     * @return void
     *
     * @throws Exception
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_auto79');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param   string  $id  A prefix for the store id.
     *
     * @return   string A store id.
     *
     * @since    1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return   JDatabaseQuery
     *
     * @since    1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'DISTINCT a.*'
                )
        );
        $query->from('`#__auto79_articles` AS a');

//        // Join over the users for the checked out user
//        $query->select("uc.name AS uEditor");
//        $query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
//
//        // Join over the user field 'created_by'
//        $query->select('`created_by`.name AS `created_by`');
//        $query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');
//
//        // Join over the user field 'modified_by'
//        $query->select('`modified_by`.name AS `modified_by`');
//        $query->join('LEFT', '#__users AS `modified_by` ON `modified_by`.id = a.`modified_by`');
        // Filter by published state
        $published = $this->getState('filter.state');

        if (is_numeric($published)) {
            $query->where('a.state = ' . (int) $published);
        } elseif ($published === '') {
            $query->where('(a.state IN (0, 1))');
        }

        // Filter by search in title
        $search = $this->getState('filter.search');

        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.category_id LIKE ' . $search . '  OR  a.province LIKE ' . $search . ' )');
            }
        }

        // Filtering category_id
        $filter_category_id = $this->state->get("filter.category_id");

        if ($filter_category_id !== null && (is_numeric($filter_category_id) || !empty($filter_category_id))) {
            $query->where("a.`category_id` = '" . $db->escape($filter_category_id) . "'");
        }

        // Filtering province
        $filter_province = $this->state->get("filter.province");

        if ($filter_province !== null && (is_numeric($filter_province) || !empty($filter_province))) {
            $query->where("a.`province` = '" . $db->escape($filter_province) . "'");
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');

        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }
//echo $query;exit();
        return $query;
    }

    /**
     * Get an array of data items
     *
     * @return mixed Array of data items on success, false on failure.
     */
    public function getItems() {
        $items = parent::getItems();

        foreach ($items as $oneItem) {
            $oneItem->advertsid = $oneItem->postid;
            if (isset($oneItem->postid)) {
                $values = explode(',', $oneItem->postid);

                $textValue = array();
                foreach ($values as $value) {
                    if (!empty($value)) {
                        $db = JFactory::getDbo();
                        $query = "SELECT title FROM #__adverts79_adverts WHERE id =" . $value;
                        $db->setQuery($query);
                        $results = $db->loadObject();
                        if ($results) {
                            $textValue[] = $results->title;
                        }
                    }
                }

                $oneItem->postid = !empty($textValue) ? implode(', ', $textValue) : '';
            }

            if (isset($oneItem->category_id)) {
                $values = explode(',', $oneItem->category_id);

                $textValue = array();
                foreach ($values as $value) {
                    if (!empty($value)) {
                        $db = JFactory::getDbo();
                        $query = "SELECT title FROM #__adverts79_categories WHERE id =" . $value;
                        $db->setQuery($query);
                        $results = $db->loadObject();

                        if ($results) {
                            $textValue[] = $results->title;
                        }
                    }
                }

                $oneItem->category_id = !empty($textValue) ? implode(', ', $textValue) : $oneItem->category_id;
            }

            if (isset($oneItem->province)) {
                $values = explode(',', $oneItem->province);

                $textValue = array();
                foreach ($values as $value) {
                    if (!empty($value)) {
                        $db = JFactory::getDbo();
                        $query = "SELECT id, title FROM #__address79_province HAVING id LIKE '" . $value . "'";
                        $db->setQuery($query);
                        $results = $db->loadObject();

                        if ($results) {
                            $textValue[] = $results->title;
                        }
                    }
                }

                $oneItem->province = !empty($textValue) ? implode(', ', $textValue) : $oneItem->province;
            }
        }

        return $items;
    }

}