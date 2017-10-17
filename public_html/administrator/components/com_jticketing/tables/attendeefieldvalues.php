<?php
/**
 * @version    SVN: <svn_id>
 * @package    JTicketing
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2015 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */
// No direct access
defined('_JEXEC') or die;
jimport('joomla.database.table');

/**
 * question Table class
 *
 * @since  1.5
 */
class JticketingTableAttendeeFieldValues extends JTable
{
	/**
	 * Constructor
	 *
	 * @param   JDatabaseDriver  &$db  Database object
	 *
	 * @since  1.5
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__jticketing_attendee_field_values', 'id', $db);
	}
}
