<?php
/**
 * @package     CSVI
 * @subpackage  Fields
 *
 * @author      Roland Dalmulder <contact@csvimproved.com>
 * @copyright   Copyright (C) 2006 - [year] RolandD Cyber Produksi. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://csvimproved.com
 */

defined('_JEXEC') or die;

JFormHelper::loadFieldClass('list');

/**
 * Load the fields for a given table.
 *
 * @package  CSVI
 * @since    7.4.0
 */
class CsviFormFieldJointablefields extends JFormFieldList
{
	/**
	 * The name of the form field
	 *
	 * @var    string
	 * @since  7.4.0
	 */
	protected $type = 'Jointablefields';

	/**
	 * Set the default value.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   7.4.0
	 */
	protected function getInput()
	{
		$key = isset($this->element['idfield']) ? (string) $this->element['idfield'] : false;

		if ($key)
		{
			$this->value = $this->form->getData()->get($key);
		}

		return parent::getInput();
	}

	/**
	 * Load the available tables.
	 *
	 * @return  array  A list of available tables.
	 *
	 * @since   7.4.0
	 */
	protected function getOptions()
	{
		/** @var JDatabaseDriver $db */
		$db          = JFactory::getDbo();
		$joinColumns = array();
		$joinTable   = $this->form->getData()->get('jointable');

		if ($joinTable)
		{
			$joinColumnNames = array_keys($db->getTableColumns($db->getPrefix() . $joinTable));
			$joinColumns     = array_combine($joinColumnNames, $joinColumnNames);
		}

		// Load the values from the XML definition
		return array_merge(parent::getOptions(), $joinColumns);
	}
}
