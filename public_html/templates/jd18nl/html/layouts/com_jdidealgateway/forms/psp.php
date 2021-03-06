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

/** @var array $displayData */
$jdideal = $displayData['jdideal'];
$data    = $displayData['data'];
$root    = $displayData['root'];
$output  = $displayData['output'];

// Check for the JavaScript
$js = '';

if (array_key_exists('banks', $output) || array_key_exists('cards', $output))
{
	$js = 'onchange="';
	$js .= <<<JS
if (document.getElementById('payment').value != 'ideal' && document.getElementById('banks') !== null)
{ 
	document.getElementById('banks').style.display = 'none' 
}
else if (document.getElementById('banks') !== null)
{
	document.getElementById('banks').style.display = 'block'
}

if (document.getElementById('payment').value != 'giftcard' && document.getElementById('cards') !== null)
{
		document.getElementById('cards').style.display = 'none'
}
else if (document.getElementById('payment').value == 'giftcard' && document.getElementById('cards') !== null)
{
	document.getElementById('cards').style.display = 'block'
}
JS;
	$js .= '"';
}
// Load the stylesheet
JHtml::stylesheet('com_jdidealgateway/payment.css', null, true);
?>
<div id="paybox">
	<?php
		// Show custom HTML
		echo $data->custom_html;
	?>
	<form name="idealform<?php echo $data->logid; ?>" id="idealform<?php echo $data->logid; ?>" action="<?php echo $root; ?>index.php?option=com_jdidealgateway&task=checkideal.send&format=raw" method="post" target="_self">
		<input type="hidden" name="logid" value="<?php echo $data->logid; ?>">
		<div id="paybox_links">
			<div id="paybox_banks">
				<?php
				if (!array_key_exists('redirect', $output) || $output['redirect'] === 'wait')
				{
					foreach ($output as $name => $options)
					{
						switch ($name)
						{
							case 'payments':
								// Create the list of possible payment methods
								if (count($options) > 1)
								{
									echo JHtml::_(
										'select.genericlist',
										$options,
										'payment',
										$js

									);
								}
								else
								{
									$payment = array_key_exists(0, $options) ? $options[0]->value : '';

									echo '<input type="hidden" name="payment" value="' . $payment . '">';
								}
								break;
							case 'banks':
								if ('' === $data->banks && is_array($options) && $jdideal->get('subpayment', 1))
								{
									echo JHtml::_(
										'select.groupedlist',
										$options,
										'banks',
										array(),
										'id',
										'name'
									);
								}
								else
								{
									echo '<input type="hidden" name="banks" value="' . $data->banks . '">';
								}
								break;
							case 'cards':
								if (is_array($options) && $jdideal->get('subpayment', 1))
								{
									$attributes = '';

									if (array_key_exists('banks', $output))
									{
										$attributes = 'style="display: none;';
									}

									echo JHtml::_(
										'select.genericlist',
										$options,
										'cards',
										$attributes
									);
								}
								else
								{
									echo '<input type="hidden" name="cards" value="">';
								}
								break;
						}
					}
				}
				elseif (array_key_exists('payments', $output) && array_key_exists(0, $output['payments']))
				{
					echo '<input type="hidden" name="payment" value="' . $output['payments'][0]->value . '">';
				}
				?>
			</div>
			<div class="clr"></div>
			<br />
			<div id="paybox_button">
				<?php
					echo JHtml::link(
						$root,
						JText::_('COM_JDIDEALGATEWAY_GO_TO_CASH_REGISTER'),
						'class="button btn btn-primary" onclick="document.idealform' . $data->logid . '.submit(); return false;"'
					);
				?>
			</div>
		</div>
	</form>
</div>
<?php
if (isset($output['redirect']))
{
	// Do we need to redirect
	$payment_info = '';

	switch ($output['redirect'])
	{
		case 'direct':
			/* go straight to the bank */
			$payment_info = '<script type="text/javascript">';
			$payment_info .= '	document.idealform' . $data->logid . '.submit();';
			$payment_info .= '</script>';
			break;
		case 'timer':
			/* show timer before going to bank */
			$payment_info = '<div id="showtimer">' . JText::_('COM_JDIDEALGATEWAY_REDIRECT_5_SECS');
			$payment_info .= ' ' . JHtml::link(
					'',
					JText::_('COM_JDIDEALGATEWAY_DO_NOT_REDIRECT'),
					array('onclick' => 'clearTimeout(timeout);return false;')
				) . '</div>';
			$payment_info .= '<script type="text/javascript">';
			$payment_info .= '	var timeout = setTimeout("document.idealform' . $data->logid . '.submit()", 5000);';
			$payment_info .= '</script>';
			break;
		case 'wait':
		default:
			break;
	}

	echo $payment_info;
}
