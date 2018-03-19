<?php
/**
 * @package     CSVI
 * @subpackage  J2Store
 *
 * @author      RolandD Cyber Produksi <contact@csvimproved.com>
 * @copyright   Copyright (C) 2006 - [year] RolandD Cyber Produksi. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://csvimproved.com
 */

defined('_JEXEC') or die;

/**
 * J2Store addon installer.
 *
 * @package     CSVI
 * @subpackage  J2Store
 * @since       7.3.0
 */
class Plgcsviaddonj2storeInstallerScript
{
	/**
	 * Actions to perform before installation.
	 *
	 * @param   string  $route   The type of installation being run.
	 * @param   object  $parent  The parent object.
	 *
	 * @return  bool  True on success | False on failure.
	 *
	 * @since   7.3.0
	 */
	public function preflight($route, $parent)
	{
		if ($route == 'install')
		{
			// Check if CSVI Pro is installed
			if (!file_exists(JPATH_ADMINISTRATOR . '/components/com_csvi/'))
			{
				JFactory::getApplication()->enqueueMessage(JText::_('PLG_CSVIADDON_CSVI_NOT_INSTALLED'), 'error');

				return false;
			}
		}

		return true;
	}

	/**
	 * Actions to perform after installation.
	 *
	 * @param   object  $parent  The parent object.
	 *
	 * @return  bool  True on success | False on failure.
	 *
	 * @since   7.3.0
	 */
	public function postflight($parent)
	{
		// Load the application
		$app = JFactory::getApplication();
		$db  = JFactory::getDbo();

		// Clear the cache
		$cache = JFactory::getCache('com_csvi', '');
		$cache->clean('com_csvi');

		try
		{
			$query = $db->getQuery(true)
				->update($db->quoteName('#__extensions'))
				->set($db->quoteName('enabled') . ' =  1')
				->where($db->quoteName('type') . ' = ' . $db->quote('plugin'))
				->where($db->quoteName('element') . ' = ' . $db->quote('j2store'))
				->where($db->quoteName('folder') . ' = ' . $db->quote('csviaddon'));

			$db->setQuery($query)->execute();
			$app->enqueueMessage(JText::_('PLG_CSVIADDON_PLUGIN_ENABLED'));
		}
		catch (Exception $e)
		{
			$app->enqueueMessage($e->getMessage());

			return false;
		}

		return true;
	}
}
