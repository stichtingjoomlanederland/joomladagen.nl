<?php
/**
 * @package         Regular Labs Library
 * @version         17.2.6639
 * 
 * @author          Peter van Westen <info@regularlabs.com>
 * @link            http://www.regularlabs.com
 * @copyright       Copyright © 2017 Regular Labs All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

namespace RegularLabs\Library\Condition;

defined('_JEXEC') or die;

/**
 * Class ContentPagetype
 * @package RegularLabs\Library\Condition
 */
class ContentPagetype
	extends Content
	implements \RegularLabs\Library\Api\ConditionInterface
{
	public function pass()
	{
		$components = ['com_content', 'com_contentsubmit'];

		if (!in_array($this->request->option, $components))
		{
			return $this->_(false);
		}
		if ($this->request->view == 'category' && $this->request->layout == 'blog')
		{
			$view = 'categoryblog';
		}
		else
		{
			$view = $this->request->view;
		}

		return $this->passSimple($view);
	}
}
