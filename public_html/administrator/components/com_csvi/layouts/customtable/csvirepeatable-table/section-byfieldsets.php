<?php
/**
 * @package     CSVI
 * @subpackage  Plugin.Multireplace
 *
 * @author      RolandD Cyber Produksi <contact@csvimproved.com>
 * @copyright   Copyright (C) 2006 - 2018 RolandD Cyber Produksi. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://csvimproved.com
 */

defined('_JEXEC') or die;

/**
 * Make thing clear
 *
 * @var JForm   $form       The form instance for render the section
 * @var string  $basegroup  The base group name
 * @var string  $group      Current group name
 * @var array   $buttons    Array of the buttons that will be rendered
 * @var int     $row        The row number being rendered
 */
extract($displayData);

if (!array_key_exists('row', $displayData))
{
	$row = 1;
}
?>

<tr class="subform-repeatable-group" data-base-name="<?php echo $basegroup; ?>" data-group="<?php echo $group; ?>">
	<?php foreach($form->getFieldsets() as $fieldset): ?>
		<td class="<?php if (!empty($fieldset->class)){ echo $fieldset->class; } ?>">
			<?php foreach($form->getFieldset($fieldset->name) as $field): ?>
			<div class="<?php echo $field->labelclass; ?>">
				<?php
					if ($row > 0 || ($row === 0 && $fieldset->name === 'custom'))
					{
						echo '<div class="inputfield">' . $field->input . '</div>';
					}
				?>
				</div>
			<?php endforeach; ?>
		</td>
	<?php endforeach; ?>
	<?php if (!empty($buttons)):?>
		<td>
			<div class="btn-group">
				<?php if (!empty($buttons['add'])):?><a class="group-add btn btn-mini button"><span class="icon-plus"></span> </a><?php endif;?>
				<?php if (!empty($buttons['remove'])):?><a class="group-remove btn btn-mini button"><span class="icon-minus"></span> </a><?php endif;?>
				<?php if (!empty($buttons['move'])):?><a class="group-move btn btn-mini button"><span class="icon-menu"></span> </a><?php endif;?>
			</div>
		</td>
	<?php endif; ?>
</tr>