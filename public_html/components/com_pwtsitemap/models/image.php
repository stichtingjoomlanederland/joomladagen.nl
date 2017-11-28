<?php
/**
 * @package    Pwtsitemap
 *
 * @author     Perfect Web Team <extensions@perfectwebteam.com>
 * @copyright  Copyright (C) 2016 - 2017 Perfect Web Team. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link       https://extensions.perfectwebteam.com
 */

defined('_JEXEC') or die;

JLoader::register('PwtSitemapModelSitemap', JPATH_ROOT . '/components/com_pwtsitemap/models/sitemap.php');
JLoader::register('PwtSitemapImageItem', JPATH_ROOT . '/components/com_pwtsitemap/models/sitemap/pwtsitemapimageitem.php');

/**
 * PWT Sitemap Component Multi-language Model
 *
 * @since  1.0.0
 */
class PwtSitemapModelImage extends PwtSitemapModelSitemap
{
	public function __construct(array $config = array())
	{
		parent::__construct($config);

		$this->type = 'image';
	}

	/**
	 * Add a menu item to the sitemap
	 *
	 * @param   $menuitem  JMenuItem  Menu item to add to the sitemap
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	protected function addMenuItemToSitemap($menuitem)
	{
		// Empty because menu items do not have images
	}

	/**
	 * Add a array of PwtSitemapItems to the sitemap (used for the result of plugin triggers)
	 *
	 * @param   $items  array  Menu item to add to the sitemap
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	protected function addItemsToSitemap($items)
	{
		foreach ($items as $item)
		{
			if (isset($item->images) && count($item->images) != 0)
			{
				$this->sitemap->addItem($item);
			}
		}
	}
}