<?php
/**
 * Akeeba Engine
 * The modular PHP5 site backup engine
 *
 * @copyright Copyright (c)2006-2016 Nicholas K. Dionysopoulos
 * @license   GNU GPL version 3 or, at your option, any later version
 * @package   akeebaengine
 *
 *
 * This file uses the ZipArchive class to create and add files to existing ZIP
 * archives. For more information on the use of this class, please see:
 * 1. http://devzone.zend.com/article/2105 (tutorial)
 * 2. http://www.php.net/manual/en/class.ziparchive.php (reference)
 *
 * That said, the ZipArchive class is terribly inflexible when it comes down to
 * features already implemented in Akeeba Engine's Zip such as archive
 * splitting, chunked processing of very large files and processing of symlinks.
 * We deem it only suitable for small sites, without large files, running on a
 * decent hosting facility.
 */

namespace Akeeba\Engine\Archiver;

// Protection against direct access
defined('AKEEBAENGINE') or die();

use Akeeba\Engine\Factory;
use Psr\Log\LogLevel;

class Zipnative extends Base
{
	/** @var string The name of the file holding the ZIP's data, which becomes the final archive */
	private $_dataFileName;

	/** @var \ZipArchive An instance of the PHP ZIPArchive class */
	private $zip = null;

	/** @var int Running sum of bytes added to the archive */
	private $runningSum = 0;

	/**
	 * Class constructor - initializes internal operating parameters
	 *
	 * @return Zipnative
	 */
	public function __construct()
	{
		Factory::getLog()->log(LogLevel::DEBUG, __CLASS__ . " :: New instance");

		if ( !class_exists('\ZipArchive'))
		{
			$this->setError('Your server does not support the ZipArchive extension. Please use a different Archiver Engine and retry backing up your site');
		}

		parent::__construct();
	}

	/**
	 * Common code which gets called on instance creation or wake-up (unserialization)
	 *
	 * @codeCoverageIgnore
	 *
	 * @return  void
	 */
	public function  __bootstrap_code()
	{
		parent::__bootstrap_code();

		// So that the first run doesn't crash!
		if (empty($this->_dataFileName))
		{
			return;
		}

		// Try to reopen the ZIP
		$this->zip = new \ZipArchive;

		if ( !file_exists($this->_dataFileName))
		{
			$res = $this->zip->open($this->_dataFileName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
		}
		else
		{
			$res = $this->zip->open($this->_dataFileName);
		}

		if ($res !== true)
		{
			switch ($res)
			{
				case \ZipArchive::ER_EXISTS:
					$this->setError("The archive {$this->_dataFileName} already exists");
					break;

				case \ZipArchive::ER_INCONS:
					$this->setError("Inconsistent archive {$this->_dataFileName} detected");
					break;

				case \ZipArchive::ER_INVAL:
					$this->setError("Invalid archive {$this->_dataFileName} detected");
					break;

				case \ZipArchive::ER_MEMORY:
					$this->setError("Not enough memory to process archive {$this->_dataFileName}");
					break;

				case \ZipArchive::ER_NOENT:
					$this->setError("Unexpected ZipArchive::ER_NOENT error processing archive {$this->_dataFileName}");
					break;

				case \ZipArchive::ER_NOZIP:
					$this->setError("File {$this->_dataFileName} is not a ZIP archive!");
					break;

				case \ZipArchive::ER_OPEN:
					$this->setError("Could not open archive file {$this->_dataFileName} for writing");
					break;

				case \ZipArchive::ER_READ:
					$this->setError("Could not read from archive file {$this->_dataFileName}");
					break;

				case \ZipArchive::ER_SEEK:
					$this->setError("Could not seek into position while processing archive file {$this->_dataFileName}");
					break;
			}
		}
	}

	/**
	 * Initialises the archiver class, creating the archive from an existent
	 * installer's JPA archive.
	 *
	 * @param string $sourceJPAPath     Absolute path to an installer's JPA archive
	 * @param string $targetArchivePath Absolute path to the generated archive
	 * @param array  $options           A named key array of options (optional). This is currently not supported
	 *
	 * @return  void
	 */
	public function initialize($targetArchivePath, $options = array())
	{
		Factory::getLog()->log(LogLevel::DEBUG, __CLASS__ . " :: initialize - archive $targetArchivePath");

		// Get names of temporary files
		$this->_dataFileName = $targetArchivePath;

		// Try to kill the archive if it exists
		Factory::getLog()->log(LogLevel::DEBUG, __CLASS__ . " :: Killing old archive");

		$fp = fopen($this->_dataFileName, "wb");

		if ( !($fp === false))
		{
			ftruncate($fp, 0);
			fclose($fp);
		}
		else
		{
			@unlink($this->_dataFileName);
		}

		$this->runningSum = 0;

		// Make sure we open the file
		$this->__bootstrap_code();
	}

	/**
	 * In this engine, we have no finalization, really
	 *
	 * @return  void
	 */
	public function finalize()
	{
		$this->zip->close();

		if (function_exists('chmod'))
		{
			chmod($this->_dataFileName, 0666);
		}
	}

	/**
	 * Returns a string with the extension (including the dot) of the files produced
	 * by this class.
	 *
	 * @return string
	 */
	public function getExtension()
	{
		return '.zip';
	}

	/**
	 * The most basic file transaction: add a single entry (file or directory) to
	 * the archive.
	 *
	 * @param bool   $isVirtual        If true, the next parameter contains file data instead of a file name
	 * @param string $sourceNameOrData Absolute file name to read data from or the file data itself is $isVirtual is
	 *                                 true
	 * @param string $targetName       The (relative) file name under which to store the file in the archive
	 *
	 * @return bool True on success, false otherwise
	 */
	protected function _addFile($isVirtual, &$sourceNameOrData, $targetName)
	{
		if (!is_object($this->zip))
		{
			return false;
		}

		if (!$isVirtual)
		{
			Factory::getLog()->log(LogLevel::DEBUG, __CLASS__ . " :: Adding $sourceNameOrData");

			if (is_dir($sourceNameOrData))
			{
				$result = $this->zip->addEmptyDir($targetName);
			}
			else
			{
				$this->runningSum += filesize($sourceNameOrData);
				$result = $this->zip->addFile($sourceNameOrData, $targetName);
			}
		}
		else
		{
			Factory::getLog()->log(LogLevel::DEBUG, '  Virtual add:' . $targetName . ' (' . strlen($sourceNameOrData) . ')');
			$this->runningSum += strlen($sourceNameOrData);

			if (empty($sourceNameOrData))
			{
				$result = $this->zip->addEmptyDir($targetName);
			}
			else
			{
				$result = $this->zip->addFromString($targetName, $sourceNameOrData);
			}
		}

		$this->zip->close();
		$this->__bootstrap_code();

		return true;
	}
}