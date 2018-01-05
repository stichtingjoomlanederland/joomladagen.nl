<?php
/**
 * @package    Pwtsitemap
 *
 * @author     Perfect Web Team <extensions@perfectwebteam.com>
 * @copyright  Copyright (C) 2016 - 2018 Perfect Web Team. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link       https://extensions.perfectwebteam.com
 */

defined('_JEXEC') or die;

/**
 * PWT Sitemap Item model
 *
 * @since   1.0.0
 */
class PwtSitemapModelItem extends JModelAdmin
{
	/**
	 * The type alias for this content type.
	 *
	 * @var      string
	 * @since    1.0.0
	 */
	public $typeAlias = 'com_pwtsitemap.item';

	/**
	 * Allowed batch commands
	 *
	 * @var    array
	 * @since  1.0.0
	 */
	protected $batch_commands = array(
		'addtohtmlsitemap' => 'batchAddToHtmlSitemap',
		'addtoxmlsitemap' => 'batchAddToXmlSitemap'
	);

	/**
	 * Getting the form from the model.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  JForm|boolean  A JForm object on success, false on failure
	 *
	 * @since   12.2
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Empty because the model is currently only used for batch operations

		return parent::getForm($data, $loadData);
	}

	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $name     The table name. Optional.
	 * @param   string  $prefix   The class prefix. Optional.
	 * @param   array   $options  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.0.0
	 * @throws  Exception
	 */
	public function getTable($name = '', $prefix = 'Table', $options = array())
	{
		// Return the MenusTable because the batch functions expect us to use a table
		JLoader::register('MenusTableMenu', JPATH_ADMINISTRATOR . '/components/com_menus/tables/menu.php');

		return parent::getTable('Menu', 'MenusTable', $options);
	}

	/**
	 * Batch to change the `AddToHtmlSitemap` parameter
	 *
	 * @param   integer  $value     The new parameter value
	 * @param   array    $pks       An array of row IDs.
	 * @param   array    $contexts  An array of item contexts.
	 *
	 * @return  bool  True on success, boolean false on failure.
	 *
	 * @since   1.0.0
	 */
	public function batchAddToHtmlSitemap($value, $pks, $contexts)
	{
		// Use strings because 0 will be seen as empty with as result a failing batch operation
		if ($value == 'yes')
		{
			$value = 1;
		}
		else
		{
			$value = 0;
		}

		foreach ($pks as $id)
		{
			PwtSitemapHelper::SaveMenuItemParameter($id, "addtohtmlsitemap", $value);
		}

		return true;
	}

	/**
	 * Batch to change the `AddToXmlSitemap` parameter
	 *
	 * @param   integer  $value     The new parameter value
	 * @param   array    $pks       An array of row IDs.
	 * @param   array    $contexts  An array of item contexts.
	 *
	 * @return  bool  True on success, boolean false on failure.
	 *
	 * @since   1.0.0
	 */
	public function batchAddToXmlSitemap($value, $pks, $contexts)
	{
		// Use strings because 0 will be seen as empty with as result a failing batch operation
		if ($value == 'yes')
		{
			$value = 1;
		}
		else
		{
			$value = 0;
		}

		foreach ($pks as $id)
		{
			PwtSitemapHelper::SaveMenuItemParameter($id, "addtoxmlsitemap", $value);
		}

		return true;
	}
}