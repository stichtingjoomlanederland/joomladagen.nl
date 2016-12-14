<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);
$images  = json_decode($this->item->images);

// Load Template helper
$this->template = JFactory::getApplication()->getTemplate();
include_once JPATH_THEMES . '/' . $this->template . '/helper.php';
//// Load JLayouts helper
//require_once JPATH_THEMES . '/' . $this->template . '/html/layouts/perfectlayout/render.php';

$showintroimage = PWTTemplateHelper::getParamShowintroimage();

if ($params->get('access-view')) :
	$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
else :
	$menu   = JFactory::getApplication()->getMenu();
	$active = $menu->getActive();
	$itemId = $active->id;
	$link   = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
	$link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language)));
endif;

$unpublished = $this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != JFactory::getDbo()->getNullDate());
?>
<?php
if ($unpublished)
{
	echo '<div class="system-unpublished">';
}
?>

<?php
if($showintroimage)
{
	switch (true)
	{
		case (isset($images->image_intro) && !empty($images->image_intro) && $this->item->catid == 37):
			echo '<div class="card__image card__image--border">';
			echo JLayoutHelper::render('joomla.content.intro_image', $this->item);
			echo '</div>';
			break;
		case (isset($images->image_intro) && !empty($images->image_intro)):
			echo '<div class="card__image">';
			echo JLayoutHelper::render('joomla.content.intro_image', $this->item);
			echo '</div>';
			break;
		default:
			echo '<div class="card__image">';
			echo '&nbsp;';
			echo '</div>';
	}
}
?>

<div class="card__content<?php echo $showintroimage ? "":" card__content--hideimage"; ?>">
    <div class="card__header">
        <?php echo JLayoutHelper::render('perfectlayout.template.content.create_date', array('date' => $this->item->created, 'class' => 'blog', 'format' => 'DATE_FORMAT_LC4')); ?>

        <h2 itemprop="name">
			<?php echo $this->item->title; ?>
        </h2>

		<?php // Content is generated by content plugin event "onContentAfterTitle" ?>
		<?php echo $this->item->event->afterDisplayTitle; ?>
    </div>

    <div class="card__body<?php echo($params->get('show_publish_date') ? ' card__body--create' : ''); ?>">

		<?php // Content is generated by content plugin event "onContentBeforeDisplay" ?>
		<?php echo $this->item->event->beforeDisplayContent; ?>

		<?php if ($params->get('show_publish_date')) : ?>
			<?php echo JLayoutHelper::render('perfecttemplate.content.create_date', array('date' => $this->item->created, 'class' => 'card', 'format' => 'DATE_FORMAT_LC4')); ?>
		<?php endif; ?>

		<?php echo $this->item->introtext; ?>
    </div>
    <div class="card__actions">
	    <?php $urls = json_decode($this->item->urls);?>
	    <div class="card__actions speakersocial">
		    <?php
		        // Facebook
		        if ($urls->urlc)
		        {
		        	echo JHtml::_('link', $urls->urlc, '<span class="speakersocial__text">' . $this->item->title . '</span>', array('class' => 'speakersocial__icon speakersocial__icon--facebook'));
		        }

		        // Twitter
			    if ($urls->urlb)
			    {
				    echo JHtml::_('link', $urls->urlb, '<span class="speakersocial__text">' . $this->item->title . '</span>', array('class' => 'speakersocial__icon speakersocial__icon--twitter', 'target' => '_blank'));
			    }

			    // LinkedIn
			    if ($urls->urlc)
			    {
				    echo JHtml::_('link', $urls->urlc, '<span class="speakersocial__text">' . $this->item->title . '</span>', array('class' => 'speakersocial__icon speakersocial__icon--linkedin', 'target' => '_blank'));
			    }

			    // Website
			    if ($urls->urla)
			    {
				    echo JHtml::_('link', $urls->urla, '<span class="speakersocial__text">' . $urls->urla . '</span>', array('class' => 'speakersocial__icon speakersocial__icon--website', 'target' => '_blank'));
			    }
		        ?>
	    </div>
    </div>
</div>

<?php
if ($unpublished)
{
	echo '</div>';
}
?>
<?php // Content is generated by content plugin event "onContentAfterDisplay" ?>
<?php echo $this->item->event->afterDisplayContent; ?>

