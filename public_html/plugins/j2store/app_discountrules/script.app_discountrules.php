<?php
/**
 * @package J2Store
 * @copyright Copyright (c)2014-17 Ramesh Elamathi / J2Store.org
 * @license GNU GPL v3 or later
 */
/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

class plgJ2StoreApp_discountrulesInstallerScript {

    function preflight( $type, $parent ) {

        if(!JComponentHelper::isEnabled('com_j2store')) {
            Jerror::raiseWarning(null, 'J2Store not found. Please install J2Store before installing this plugin');
            return false;
        }

        jimport('joomla.filesystem.file');
        $version_file = JPATH_ADMINISTRATOR.'/components/com_j2store/version.php';
        if (JFile::exists ( $version_file )) {
            require_once($version_file);
            // abort if the current J2Store release is older
            if (version_compare ( J2STORE_VERSION, '3.2.5', 'lt' )) {
                Jerror::raiseWarning ( null, 'You need at least J2Store 3.2.5 for this app to work' );
                return false;
            }
        } else {
            Jerror::raiseWarning ( null, 'J2Store not found or the version file is not found. Make sure that you have installed J2Store before installing this plugin' );
            return false;
        }

        $db = JFactory::getDbo ();
        // get the table list
        $tables = $db->getTableList ();
        // get prefix
        $prefix = $db->getPrefix ();
        if (! in_array ( $prefix . 'j2store_appdiscountmethods', $tables )) {
            $query = "CREATE TABLE IF NOT EXISTS `#__j2store_appdiscountmethods` (
			`j2store_appdiscountmethod_id` int(11) NOT NULL AUTO_INCREMENT,
			`discount_method_name` varchar(255) NOT NULL,
			`discount_type` varchar(255) NOT NULL,
			`discount_user_group` varchar(255) NOT NULL,
			`discount_geozone` varchar(255) NOT NULL,		
			PRIMARY KEY (`j2store_appdiscountmethod_id`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8";
            $this->_executeQuery ( $query );
        }

        return true;
    }

    private function _executeQuery($query) {
        $db = JFactory::getDbo ();
        $db->setQuery ( $query );
        try {
            $db->execute ();
        } catch ( Exception $e ) {
            // do nothing. we dont want to fail the install process.
            echo $e;
        }
    }

}