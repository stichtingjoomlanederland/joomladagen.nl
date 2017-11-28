<?php
/**
 * @version    SVN: <svn_id>
 * @package    Com_Jticketing
 * @copyright  Copyright (C) 2005 - 2014. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * Jticketing is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
// No direct access to this file
defined('_JEXEC') or die;

// Import helper for date and time format
$helperPath = JPATH_SITE . '/components/com_jticketing/helpers/time.php';

if (!class_exists('JticketingTimeHelper'))
{
	JLoader::register('JticketingTimeHelper', $helperPath);
	JLoader::load('JticketingTimeHelper');
}

/**
 * com_jticketing Controller
 *
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 * @since       0.0.9
 */
class JTicketingControllerEvent extends JControllerForm
{
	/**
	 * Get venue list
	 *
	 * @return null
	 *
	 * @since   1.6
	 */
	public function getVenueList()
	{
		$input  = JFactory::getApplication()->input->post;
		$eventData["radioValue"] = $input->get('radioValue', '', 'STRING');
		$eventData["enforceVendor"] = $input->get('enforceVendor', '', 'STRING');

		if ($eventData["enforceVendor"] == 1)
		{
			$eventData["vendor_id"] = $input->get('vendor_id', '', 'INTEGER');
		}
		else
		{
			$eventData["created_by"] = $input->get('created_by', '', 'STRING');
		}

		$eventData["eventStartDate"] = $input->get('eventStartTime', '', 'STRING');
		$eventData["eventEndDate"] = $input->get('eventEndTime', '', 'STRING');
		$model = $this->getModel('event');
		$results = $model->getVenueList($eventData);
		echo json_encode($results);
		jexit();
	}

	/**
	 * Method to get all existing events
	 *
	 * @return	void
	 *
	 * @since	1.6
	 */
	public function getAllMeetings()
	{
		$post = JFactory::getApplication()->input->post;
		$venueId = $post->get('venueId');

		// Load AnnotationForm Model
		$model = JModelLegacy::getInstance('Venue', 'JticketingModel');
		$licenceContent = $model->getItem($venueId);
		$licence = (object) $licenceContent->params;

		if (!empty($venueId))
		{
			// TRIGGER After create event
			$dispatcher = JDispatcher::getInstance();
			JPluginHelper::importPlugin('tjevents');
			$result = $dispatcher->trigger('getAllMeetings', array($licence));
			echo json_encode($result);
		}

		jexit();
	}

	/**
	 * Method to get all existing events
	 *
	 * @return	void
	 *
	 * @since	1.6
	 */
	public function getScoID()
	{
		$post = JFactory::getApplication()->input->post;
		$venueId = $post->get('venueId');
		$venueurl = $post->get('venueurl');

		// Load AnnotationForm Model
		$model = JModelLegacy::getInstance('Venue', 'JticketingModel');
		$licenceContent = $model->getItem($venueId);
		$licence = (object) $licenceContent->params;

		if (!empty($venueId))
		{
			// TRIGGER After create event
			$dispatcher = JDispatcher::getInstance();
			JPluginHelper::importPlugin('tjevents');
			$result = $dispatcher->trigger('getscoID', array($licence, $venueurl));
			echo json_encode($result);
		}

		jexit();
	}

	/**
	 * upload media files and links
	 *
	 * @return JSON
	 *
	 * @since   2.0
	 */
	public function uploadMedia()
	{
		$input = JFactory::getApplication()->input;
		$uploadFile = $input->post->get('upload_type', '', 'string');
		$isGallary = $input->post->get('isGallary', '', 'INT');

		$model = $this->getModel('Media', 'JTicketingModel');
		$userId = JFactory::getUser()->id;
		$returnData = array();

		if ($uploadFile == "link")
		{
			$data = array();
			$data['name'] = $input->post->get('name', '', 'string');
			$data['type'] = $input->post->get('type', '', 'string');
			$data['upload_type'] = $uploadFile;
			$returnData = $model->save($data);
		}
		else
		{
			$files = $input->files->get('file', '', 'array');
			$fileType = explode("/", $files['type']);

			// Image and video specific validation

			if ($isGallary && ( $fileType[0] === 'video' || $fileType[0] === 'image' ))
			{
				$returnData = $model->save($files);
			}
			elseif (!$isGallary && $fileType[0] === 'image')
			{
				$returnData = $model->save($files);
			}
			else
			{
				echo new JResponseJson($returnData, JText::_('COM_JTICKETING_MEDIA_INVALID_FILE_TYPE'), true);
			}
		}

		if ($returnData)
		{
			echo new JResponseJson($returnData, JText::_('COM_JTICKETING_MEDIA_FILE_UPLOADED'));
		}
	}

	/**
	 * Delete media file
	 *
	 * @return JSON
	 *
	 * @since   2.0
	 */
	public function deleteMedia()
	{
		$mediaId = $this->input->get('id', '0', 'INT');

		if (!$mediaId)
		{
			return false;
		}

		$model = $this->getModel('media');
		$model->delete($mediaId);
		echo new JResponseJson(1, JText::_('COM_JTICKETING_MEDIA_FILE_DELETED'));
	}

	/**
	 * Get Rounded value
	 *
	 * @return JSON
	 *
	 * @since   2.0
	 */
	public function getRoundedValue()
	{
		$jticketingMainHelper = new jticketingmainhelper;
		$price = $this->input->get('price', 'float');

		$roundedValue = $jticketingMainHelper->getRoundedPrice($price);

		echo new JResponseJson($roundedValue);
	}

	/**
	 * Check email of vendor
	 *
	 * @return JSON
	 *
	 * @since   2.0
	 */
	public function checkUserEmail()
	{
		$userId = $this->input->get('user', '0', 'INT');
		$JticketingOrdersHelper = new JticketingOrdersHelper;
		$checkGatewayDetails  = $JticketingOrdersHelper->checkGatewayDetails($userId);
		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_tjvendors/tables');
		$vendorTable = JTable::getInstance('Vendor', 'TjvendorsTable', array());
		$vendorTable->load(array('user_id' => $userId));
		$data['vendor_id'] = $vendorTable->vendor_id;
		$data['check'] = $checkGatewayDetails;
		echo json_encode($data);
		jexit();
	}
}
