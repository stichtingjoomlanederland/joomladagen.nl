<?php
/**
 * @package     Conference
 *
 * @author      Stichting Sympathy <info@stichtingsympathy.nl>
 * @copyright   Copyright (C) 2013 - [year] Stichting Sympathy. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://stichtingsympathy.nl
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

defined('_JEXEC') or die;

$params = JComponentHelper::getParams('com_conference');

$this->template = Factory::getApplication()->getTemplate();
require_once JPATH_THEMES . '/' . $this->template . '/html/layouts/render.php';

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

$array = array(
	'title' => Text::_('COM_CONFERENCE_DAYS_TITLE')
);

echo JLayouts::render('template.content.header', $array);
?>
<section class="section__wrapper">
    <div class="container">
        <div class="content">
			<?php if (!empty($this->items)) : ?>
                <div class="tabs">
					<?php foreach ($this->items as $key => &$item) : ?>
                        <div class="tab">
                            <a class="tab-button" href="#"><?php echo $item->title; ?></a>
                            <div class="tab-content">
                                <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead class="hidden-phone">
                                    <tr>
                                        <th width="10%"></th>
		                                <?php if (!empty($this->rooms)): ?>
                                            <?php foreach ($this->rooms as $room): ?>
                                                <th width="<?php echo(90 / count($this->rooms)); ?>%"><?php echo $room->title ?></th>
		                                    <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>

                                    <tbody>
	                                <?php if (!empty($item->slots)): ?>
		                                <?php foreach ($item->slots as $slot) : ?>
                                            <?php if ($slot->general): ?>
                                                <tr class="info">
                                                    <td><?php echo HTMLHelper::_('date', $slot->start_time, 'H:i'); ?></td>
                                                    <td colspan="<?php echo(count($this->rooms)); ?>">
                                                        <?php if (isset($this->sessions[$slot->conference_slot_id][$this->generalRoom])) : ?>
                                                            <?php $session = $this->sessions[$slot->conference_slot_id][$this->generalRoom]; ?>
                                                            <?php if ($session->listview): ?>
                                                                <?php echo HTMLHelper::_('link', Route::_('index.php?option=com_conference&view=session&id=' . $session->conference_session_id), $session->title); ?>
                                                            <?php else: ?>
                                                                <?php echo $session->title ?>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

	                                        <?php if (!$slot->general): ?>
                                                <tr>
                                                    <td><?php echo HTMLHelper::_('date', $slot->start_time, 'H:i'); ?></td>
		                                            <?php if (!empty($this->rooms)): ?>
	                                                    <?php foreach ($this->rooms as $room): ?>
				                                            <?php if (isset($this->sessions[$slot->conference_slot_id][$room->conference_room_id])) : ?>
                                                                <td>
						                                            <?php $session = $this->sessions[$slot->conference_slot_id][$room->conference_room_id]; ?>
                                                                    <span class="visible-phone roomname">
                                                                    <?php echo $room->title ?>
                                                                    </span>
						                                            <?php if ($session->level): ?>
                                                                        <?php
							                                            $class = 'label ' . $session->level_label;
                                                                        echo HTMLHelper::_('link', Route::_('index.php?option=com_conference&view=levels'), $session->level, array('class' => $class));
                                                                        ?>
						                                            <?php endif; ?>
                                                                    <div class="session">
							                                            <?php if ($session->listview): ?>
								                                            <?php if ($session->slides): ?>
                                                                                <span class="icon-grid-view" rel="tooltip"
                                                                                      data-original-title="<?php echo Text::_('COM_CONFERENCE_SLIDES_AVAILABLE') ?>"></span>
								                                            <?php endif; ?>
                                                                            <a href="<?php echo Route::_('index.php?option=com_conference&view=sessions&id=' . $session->conference_session_id) ?>"><?php echo $session->title ?></a>
							                                            <?php else: ?>
								                                            <?php echo $session->title ?>
							                                            <?php endif; ?>

							                                            <?php if ($params->get('language', 0)): ?>
								                                            <?php if ($session->language == 'en'): ?>
                                                                                <img class="lang" src="media/mod_languages/images/<?php echo($session->language) ?>.gif"/>
								                                            <?php endif; ?>
							                                            <?php endif; ?>
                                                                    </div>
						                                            <?php if ($session->speakers): ?>
							                                            <?php
							                                            $sessionspeakers = array();

							                                            foreach ($session->speakers as $speaker)
							                                            {
								                                            if ($speaker->enabled)
								                                            {
									                                            $sessionspeakers[] = '<span class="icon-user"></span> <a href="index.php?option=com_conference&view=speakers&id=' . $speaker->conference_speaker_id . '">' . trim($speaker->title) . '</a>';
								                                            }
								                                            else
								                                            {
									                                            $sessionspeakers[] = '<span class="icon-user"></span> ' . trim($speaker->title);
								                                            }
							                                            }
							                                            ?>
                                                                        <div class="speaker">
                                                                            <small><?php echo implode('<br/> ', $sessionspeakers); ?></small>
                                                                        </div>
						                                            <?php endif; ?>
                                                                </td>
				                                            <?php else: ?>
                                                                <td class="hidden-phone"></td>
				                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </tr>
                                            <?php endif;?>

		                                <?php endforeach; ?>
	                                <?php endif; ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
					<?php endforeach; ?>
                </div>
			<?php endif; ?>
        </div>
    </div>
</section>

<script>
    (function () {
        'use strict'

        let tabsClass = 'tabs'
        let tabClass = 'tab'
        let tabButtonClass = 'tab-button'
        let activeClass = 'active'

        /* Activates the chosen tab and deactivates the rest */
        function activateTab(chosenTabElement) {
            let tabList = chosenTabElement.parentNode.querySelectorAll('.' + tabClass)
            for (let i = 0; i < tabList.length; i++) {
                let tabElement = tabList[i]
                if (tabElement.isEqualNode(chosenTabElement)) {
                    tabElement.classList.add(activeClass)
                } else {
                    tabElement.classList.remove(activeClass)
                }
            }
        }

        /* Initialize each tabbed container */
        let tabbedContainers = document.body.querySelectorAll('.' + tabsClass)
        for (let i = 0; i < tabbedContainers.length; i++) {
            let tabbedContainer = tabbedContainers[i]

            /* List of tabs for this tabbed container */
            let tabList = tabbedContainer.querySelectorAll('.' + tabClass)

            /* Make the first tab active when the page loads */
            activateTab(tabList[0])

            /* Activate a tab when you click its button */
            for (let i = 0; i < tabList.length; i++) {
                let tabElement = tabList[i]
                let tabButton = tabElement.querySelector('.' + tabButtonClass)
                tabButton.addEventListener('click', function (event) {
                    event.preventDefault()
                    activateTab(event.target.parentNode)
                })
            }

        }

    })()

</script>