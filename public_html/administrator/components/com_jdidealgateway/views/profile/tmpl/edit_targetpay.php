<?php
/**
 * @package    JDiDEAL
 *
 * @author     Roland Dalmulder <contact@jdideal.nl>
 * @copyright  Copyright (C) 2009 - 2017 RolandD Cyber Produksi. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link       https://jdideal.nl
 */

defined('_JEXEC') or die;
?>
<div class="span10">
	<?php echo $this->pspForm->renderFieldset('targetpay'); ?>
</div>
<div class="span2">
	<table class="table table-striped">
		<caption><?php echo JText::_('COM_JDIDEALGATEWAY_DASHBOARD_LINKS')?></caption>
		<thead>
			<tr>
				<th>
					<?php echo JText::_('COM_JDIDEALGATEWAY_PRODUCTION_DASHBOARD'); ?>
				</th>
				<th>
					<?php echo JText::_('COM_JDIDEALGATEWAY_TEST_DASHBOARD'); ?>
				</th>
			</tr>
		</thead>
		<tfoot><tr><td></td><td></td></tr></tfoot>
		<tbody>
			<tr>
				<td class="center">
					<?php
						echo JHtml::_(
							'link',
							'https://www.targetpay.com/login',
							JHtml::_('image', 'com_jdidealgateway/targetpay.png', 'Target Pay', false, true),
							'target="_new"'
						);
					?>
				</td>
				<td class="center"></td>
			</tr>
		</tbody>
	</table>
</div>
<!-- Hidden fields -->
<?php echo $this->form->getInput('newstyle', 'targetpay');
