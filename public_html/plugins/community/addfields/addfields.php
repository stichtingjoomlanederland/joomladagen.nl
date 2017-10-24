<?php
/**
 * @version    SVN: <svn_id>
 * @package    JTicketing
 * @author     Techjoomla <extensions@techjoomla.com>
 * @copyright  Copyright (c) 2009-2015 TechJoomla. All rights reserved.
 * @license    GNU General Public License version 2 or later.
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.plugin.plugin');
$lang = JFactory::getLanguage();
$lang->load('plg_community_addfields', JPATH_ADMINISTRATOR);
$lang->load('com_jticketing', JPATH_SITE);

if (file_exists(JPATH_ROOT . '/media/techjoomla_strapper/tjstrapper.php'))
{
	require_once JPATH_ROOT . '/media/techjoomla_strapper/tjstrapper.php';
	TjStrapper::loadTjAssets('com_jticketing');
}

/**
 * Model for buy for creating order and other
 *
 * @package     JTicketing
 * @subpackage  component
 * @since       1.0
 */
class PlgCommunityaddFields extends CApplications
{
	/**
	 * function to validate Integration
	 *
	 * @return  boolean  true or false
	 *
	 * @since   1.0
	 */
	public function validateIntegration()
	{
		$com_params  = JComponentHelper::getParams('com_jticketing');
		$integration = $com_params->get('integration');

		if ($integration != 1)
		{
			return false;
		}

		return true;
	}

	/**
	 * This functions is called when jomsocial event is updated
	 *
	 * @param   string  $subject  subject
	 * @param   string  $config   config
	 *
	 * @since   1.0
	 */
	public function __construct($subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadJTclasses();
	}

	/**
	 * This is called when jomsocial event creation form showed
	 *
	 * @param   STRING  $form_name  form_name
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onFormDisplay($form_name)
	{
		$app = JFactory::getApplication();
		$site = $app->isSite();

		if ($site)
		{
			$document   = JFactory::getDocument();
			$document->addStyleSheet(JUri::root(true) . '/media/com_jticketing/css/jticketing.css');
		}

		if (!$this->validateIntegration())
		{
			return false;
		}

		$html = $this->getCustomFields();
		$obj = new CFormElement;
		$obj->position = 'after';
		$obj->html = '';
		$elements = array();

		foreach ($html as $singleHtml)
		{
			$obj->html .= $singleHtml;
		}

		$elements[] = $obj;

		return $elements;
	}

	/**
	 * This is called when jomsocial event is stored
	 *
	 * @param   object  $event  event object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onEventCreate($event)
	{
		if (!$this->validateIntegration())
		{
			return false;
		}

		$this->loadJTclasses();
		$jteventHelper = new jteventHelper;

		$jteventHelper->saveEvent($event->id, '1');
	}

	/**
	 * This is called when jomsocial event is updated
	 *
	 * @param   object  $event  event object
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onEventUpdate($event)
	{
		if (!$this->validateIntegration())
		{
			return false;
		}

		$this->loadJTclasses();

		$jteventHelper = new jteventHelper;

		$jteventHelper->saveEvent($event->id, '1');
	}

	/**
	 * This function updates jomsocial table
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function loadJTclasses()
	{
		// Load all required helpers.
		$jticketingmainhelperPath = JPATH_ROOT . '/components/com_jticketing/helpers/main.php';

		if (!class_exists('jticketingmainhelper'))
		{
			JLoader::register('jticketingmainhelper', $jticketingmainhelperPath);
			JLoader::load('jticketingmainhelper');
		}

		$jticketingfrontendhelper = JPATH_ROOT . '/components/com_jticketing/helpers/frontendhelper.php';

		if (!class_exists('jticketingfrontendhelper'))
		{
			JLoader::register('jticketingfrontendhelper', $jticketingfrontendhelper);
			JLoader::load('jticketingfrontendhelper');
		}

		$jteventHelperPath = JPATH_ROOT . '/components/com_jticketing/helpers/event.php';

		if (!class_exists('jteventHelper'))
		{
			JLoader::register('jteventHelper', $jteventHelperPath);
			JLoader::load('jteventHelper');
		}
	}

	/**
	 * Gets the custom fields
	 *
	 * @return  void
	 *
	 * @since   2.0
	 */
	public function getCustomFields()
	{
		$input    = JFactory::getApplication()->input->get;
		$event_id = $input->get('eventid', '', 'GET');
		$lang = JFactory::getLanguage();
		$extension = 'com_jticketing';
		$base_dir = JPATH_ADMINISTRATOR;
		$language_tag = 'en-GB';
		$reload = true;
		$lang->load($extension, $base_dir, $language_tag, $reload);
		$this->loadJTclasses();
		$jticketingfrontendhelper = new jticketingfrontendhelper;
		$attendeeGlobalFields = $jticketingfrontendhelper->getGlobalAtendeeFields();
		$com_params = JComponentHelper::getParams('com_jticketing');
		$attendeeCheckoutConfig = $com_params->get('collect_attendee_info_checkout');
		$accessLevel = $com_params->get('show_access_level');

		$document   = JFactory::getDocument();
		$document->addStyleSheet(JUri::root(true) . '/media/com_jticketing/css/jticketing.css');

		if (!$accessLevel)
		{
		?>
		<style>
		.subform-repeatable-wrapper .form-group:last-child{
		display: none;
		}
		#tickettypes-lbl ,#attendeefields-lbl{
		display: none;
		}
		</style>
		<?php
		}

		$customFields = array();
		$customFields['ticket_title'] = '<legend>' . JText::_('COM_JTICKETING_JSEVENT_TICKET_TYPES') . '</legend>';
		$customTicketFields = $jticketingfrontendhelper->getCustomFieldTypes('ticketFields', $event_id, 'com_community');
		$customFields['ticketFields'] = '<div class="jticketing-wrapper">
			<div class="jticketing_params_container">
				<div>' . $customTicketFields . '</div>
			</div>
		</div>';

		if ($attendeeCheckoutConfig == 1)
		{
			$customAttendeeFields = $jticketingfrontendhelper->getCustomFieldTypes('attendeeFields', $event_id, 'com_community');
			$customFields['attendee_title'] = '<legend>' . JText::_('COM_JTICKETING_JSEVENT_ATTENDEE_FIELDS') . '</legend>';
			$customFields['attendeeFields'] = '<div class="jticketing-wrapper">
		<div class="jticketing_params_container">
					<div>' . $customAttendeeFields . '</div>
				</div>
			</div>';
		}

		return $customFields;
	}
}