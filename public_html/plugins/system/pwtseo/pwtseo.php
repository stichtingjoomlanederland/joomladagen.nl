<?php
/**
 * @package    Pwtseo
 *
 * @author     Perfect Web Team <extensions@perfectwebteam.com>
 * @copyright  Copyright (C) 2016 - 2018 Perfect Web Team. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link       https://extensions.perfectwebteam.com
 */

defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\Filter\OutputFilter;
use Joomla\CMS\Form\Form;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Language;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

/**
 * PWT SEO plugin
 * Plugin to give the user an approximation of the effectiveness in SEO of the article
 *
 * @since  1.0
 */
class PlgSystemPWTSEO extends CMSPlugin
{
	/**
	 * @var JDatabaseDriver
	 * @since 1.0
	 */
	protected $db;

	/**
	 * @var JApplication
	 * @since 1.0
	 */
	protected $app;

	/**
	 * Load the language file on instantiation
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Array to hold all the contexts in which our plugin works, for now only articles
	 *
	 * @var    array
	 * @since  1.0
	 */
	private $aAllowedContext = array('com_content.article', 'com_pwtseo.custom');

	/**
	 * @var    String  base update url, to decide whether to process the event or not
	 *
	 * @since  1.0.0
	 */
	private $baseUrl = 'https://extensions.perfectwebteam.com/pwt-seo';

	/**
	 * @var    String  Extension identifier, to retrieve its params
	 *
	 * @since  1.0.0
	 */
	private $extension = 'com_pwtseo';

	/**
	 * @var    String  Extension title, to retrieve its params
	 *
	 * @since  1.0.0
	 */
	private $extensiontitle = 'PWT SEO';

	/**
	 * Adding required headers for successful extension update
	 *
	 * @param   string $url     url from which package is going to be downloaded
	 * @param   array  $headers headers to be sent along the download request (key => value format)
	 *
	 * @return  boolean true    Always true, regardless of success
	 *
	 * @since   1.0.0
	 *
	 * @throws  Exception
	 */
	public function onInstallerBeforePackageDownload(&$url, &$headers)
	{
		// Are we trying to update our own extensions?
		if (strpos($url, $this->baseUrl) !== 0)
		{
			return true;
		}

		// Load language file
		$jLanguage = Factory::getLanguage();
		$jLanguage->load($this->extension, JPATH_ADMINISTRATOR . '/components/' . $this->extension . '/', 'en-GB', true, true);
		$jLanguage->load($this->extension, JPATH_ADMINISTRATOR . '/components/' . $this->extension . '/', null, true, false);

		// Get the Download ID from component params
		$downloadId = ComponentHelper::getComponent($this->extension)->params->get('downloadid', '');

		// Set Download ID first
		if (empty($downloadId))
		{
			Factory::getApplication()->enqueueMessage(
				Text::sprintf($this->extension . '_DOWNLOAD_ID_REQUIRED',
					$this->extension,
					$this->extensiontitle
				),
				'error'
			);

			return true;
		}
		// Append the Download ID
		else
		{
			$separator = strpos($url, '?') !== false ? '&' : '?';
			$url       .= $separator . 'key=' . $downloadId;
		}

		// Get the clean domain
		$domain = '';

		if (preg_match('/\w+\..{2,3}(?:\..{2,3})?(?:$|(?=\/))/i', Uri::base(), $matches) === 1)
		{
			$domain = $matches[0];
		}

		// Append domain
		$url .= '&domain=' . $domain;

		return true;
	}

	/**
	 * Once the user is logged in, we want to check for the robots setting in global config.
	 *
	 * @param   array $options Array holding options
	 *
	 * @return  boolean  True on success
	 *
	 * @since   1.0.1
	 */
	public function onUserAfterLogin($options)
	{
		if ($this->app->isClient('administrator'))
		{
			if (Factory::getUser()->authorise('core.admin') && Factory::getConfig()->get('robots') === 'noindex, nofollow')
			{
				$this->app->enqueueMessage(Text::_('PLG_SYSTEM_PWTSEO_ERROR_NOINDEX_NOFOLLOW'), 'warning');
			}
		}

		return true;
	}

	/**
	 * Alters the form that is loaded
	 *
	 * @param   JForm  $form Object to be displayed. Use the $form->getName() method to check whether this is the form you want to work with.
	 * @param   Object $data Containing the data for the form.
	 *
	 * @return  bool True is method succeeds
	 *
	 * @since   1.0
	 */
	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof Form))
		{
			return false;
		}

		if (in_array($form->getName(), $this->aAllowedContext))
		{
			HTMLHelper::_('jquery.framework');
			$form->loadFile(JPATH_PLUGINS . '/system/pwtseo/form/' . $form->getName() . '.xml', false);

			/**
			 * TODO: seperate editor logic so we can add it depending on which editor that we are using
			 * TODO: mind the 'Toggle Editor' button
			 */

			HTMLHelper::script('plg_system_pwtseo/vue.min.js', array('version' => 'auto', 'relative' => true));
			HTMLHelper::script('plg_system_pwtseo/lodash.min.js', array('version' => 'auto', 'relative' => true));

			HTMLHelper::script('plg_system_pwtseo/pwtseo.min.js', array('version' => 'auto', 'relative' => true));
			HTMLHelper::stylesheet('plg_system_pwtseo/pwtseo.css', array('version' => 'auto', 'relative' => true));

			$iMinTitle    = (int) $this->params->get('count_min_title', 40);
			$iMaxTitle    = (int) $this->params->get('count_max_title', 50);
			$iMinMetadesc = (int) $this->params->get('count_min_metadesc', 100);
			$iMaxMetadesc = (int) $this->params->get('count_max_metadesc', 150);

			// Filter the most common terms for the word counter
			$language = new Language(isset($data->language) && $data->language !== '*' ? $data->language : null);

			$aWordsFilter = array(
				'common' => $language->getIgnoredSearchWords(),
				'lower'  => $language->getLowerLimitSearchWord(),
				'upper'  => $language->getUpperLimitSearchWord()
			);

			// All parameters required by the JS
			Factory::getDocument()->addScriptOptions('PWTSeoConfig',
				array(
					'context'                                        => $form->getName(),
					'min_title_length'                               => $iMinTitle,
					'max_title_length'                               => $iMaxTitle,
					'min_metadesc_length'                            => $iMinMetadesc,
					'max_metadesc_length'                            => $iMaxMetadesc,
					'min_focus_length'                               => (int) $this->params->get('min_focus_length', 3),
					'baseurl'                                        => Uri::root(),
					'ajaxurl'                                        => Uri::base(true) . '/index.php?option=com_ajax&format=json',
					'frontajaxurl'                                   => Uri::root() . 'index.php?option=com_ajax&format=json',
					'requirements_article_title_good'                => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ARTICLE_TITLE_GOOD'),
					'requirements_article_title_bad'                 => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ARTICLE_TITLE_BAD'),
					'requirements_page_title_good'                   => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_PAGE_TITLE_GOOD'),
					'requirements_page_title_bad'                    => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_PAGE_TITLE_BAD'),
					'requirements_meta_description_none'             => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_META_DESCRIPTION_NONE'),
					'requirements_meta_description_too_short_bad'    => Text::sprintf(
						'PLG_SYSTEM_PWTSEO_REQUIREMENTS_META_DESCRIPTION_TOO_SHORT_BAD',
						$iMinMetadesc,
						$iMaxMetadesc
					),
					'requirements_meta_description_too_short_medium' => Text::sprintf(
						'PLG_SYSTEM_PWTSEO_REQUIREMENTS_META_DESCRIPTION_TOO_SHORT_MEDIUM',
						$iMinMetadesc,
						$iMaxMetadesc
					),
					'requirements_meta_description_too_long_medium'  => Text::sprintf(
						'PLG_SYSTEM_PWTSEO_REQUIREMENTS_META_DESCRIPTION_TOO_LONG_MEDIUM',
						$iMinMetadesc,
						$iMaxMetadesc
					),
					'requirements_meta_description_medium'           => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_META_DESCRIPTION_MEDIUM'),
					'requirements_meta_description_good'             => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_META_DESCRIPTION_GOOD'),
					'requirements_images_none'                       => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_IMAGES_NONE'),
					'requirements_images_bad'                        => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_IMAGES_BAD'),
					'requirements_images_good'                       => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_IMAGES_GOOD'),
					'requirements_images_resulting_none'             => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_IMAGES_RESULTING_NONE'),
					'requirements_images_resulting_bad'              => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_IMAGES_RESULTING_BAD'),
					'requirements_images_resulting_good'             => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_IMAGES_RESULTING_GOOD'),
					'requirements_subheadings_none'                  => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_SUBHEADINGS_NONE'),
					'requirements_subheadings_bad'                   => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_SUBHEADINGS_BAD'),
					'requirements_subheadings_medium'                => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_SUBHEADINGS_MEDIUM'),
					'requirements_subheadings_good'                  => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_SUBHEADINGS_GOOD'),
					'requirements_first_paragraph_bad'               => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_FIRST_PARAGRAPH_BAD'),
					'requirements_first_paragraph_good'              => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_FIRST_PARAGRAPH_GOOD'),
					'requirements_density_none'                      => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_NONE'),
					'requirements_density_too_few_bad'               => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_TOO_FEW_BAD'),
					'requirements_density_resulting_too_few_bad'     => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_RESULTING_TOO_FEW_BAD'),
					'requirements_density_too_much_bad'              => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_TOO_MUCH_BAD'),
					'requirements_density_resulting_too_much_bad'    => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_RESULTING_TOO_MUCH_BAD'),
					'requirements_density_too_few_medium'            => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_TOO_FEW_MEDIUM'),
					'requirements_density_resulting_too_few_medium'  => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_RESULTING_TOO_FEW_MEDIUM'),
					'requirements_density_too_much_medium'           => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_TOO_MUCH_MEDIUM'),
					'requirements_density_good'                      => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_GOOD'),
					'requirements_density_resulting_good'            => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_DENSITY_RESULTING_GOOD'),
					'requirements_length_bad'                        => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ARTICLE_LENGTH_BAD'),
					'requirements_length_medium'                     => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ARTICLE_LENGTH_MEDIUM'),
					'requirements_length_good'                       => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ARTICLE_LENGTH_GOOD'),
					'requirements_page_title_length_too_few_bad'     => Text::sprintf(
						'PLG_SYSTEM_PWTSEO_REQUIREMENTS_PAGE_TITLE_LENGTH_TOO_FEW_BAD',
						$iMinTitle,
						$iMaxTitle
					),
					'requirements_page_title_length_too_much_bad'    => Text::sprintf(
						'PLG_SYSTEM_PWTSEO_REQUIREMENTS_PAGE_TITLE_LENGTH_TOO_MUCH_BAD',
						$iMinTitle,
						$iMaxTitle
					),
					'requirements_page_title_length_too_few_medium'  => Text::sprintf(
						'PLG_SYSTEM_PWTSEO_REQUIREMENTS_PAGE_TITLE_LENGTH_TOO_FEW_MEDIUM',
						$iMinTitle,
						$iMaxTitle
					),
					'requirements_page_title_length_too_much_medium' => Text::sprintf(
						'PLG_SYSTEM_PWTSEO_REQUIREMENTS_PAGE_TITLE_LENGTH_TOO_MUCH_MEDIUM',
						$iMinTitle,
						$iMaxTitle
					),
					'requirements_page_title_length_good'            => Text::sprintf(
						'PLG_SYSTEM_PWTSEO_REQUIREMENTS_PAGE_TITLE_LENGTH_GOOD',
						$iMinTitle,
						$iMaxTitle
					),
					'requirements_in_url_bad'                        => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_IN_URL_BAD'),
					'requirements_in_url_good'                       => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_IN_URL_GOOD'),
					'requirements_not_used_loading'                  => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_LOADING'),
					'requirements_not_used_good'                     => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_NOT_USED_GOOD'),
					'requirements_not_used_medium'                   => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_NOT_USED_MEDIUM'),
					'requirements_not_used_bad'                      => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_NOT_USED_BAD'),
					'requirements_robots_reachable_good'             => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ROBOTS_REACHABLE_GOOD'),
					'requirements_robots_reachable_bad'              => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ROBOTS_REACHABLE_BAD'),
					'requirements_article_title_unique_none'         => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ARTICLE_TITLE_UNIQUE_NONE'),
					'requirements_article_title_unique_good'         => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ARTICLE_TITLE_UNIQUE_GOOD'),
					'requirements_article_title_unique_bad'          => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_ARTCILE_TITLE_UNIQUE_BAD'),
					'requirements_metadesc_unique_none'              => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_METADESC_UNIQUE_NONE'),
					'requirements_metadesc_unique_good'              => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_METADESC_UNIQUE_GOOD'),
					'requirements_metadesc_unique_bad'               => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_METADESC_UNIQUE_BAD'),
					'information_most_common_words'                  => Text::_('PLG_SYSTEM_PWTSEO_REQUIREMENTS_INFORMATION_COMMON_WORDS'),
					'polling_interval'                               => (int) $this->params->get('poll_interval', 1) ?: 1,
					'show_counters'                                  => (int) $this->params->get('show_counters', 1),
					'found_resulting_page'                           => Text::_('PLG_SYSTEM_PWTSEO_FOUND_RESULTING_PAGE'),
					'resulting_page_unreachable'                     => Text::_('PLG_SYSTEM_PWTSEO_RESULTING_PAGE_UNREACHABLE'),
					'error_invalid_url'                              => Text::_('PLG_SYSTEM_PWTSEO_ERROR_INVALID_URL'),
					'words_filter'                                   => $aWordsFilter
				)
			);
		}

		return true;
	}

	/**
	 * Alters the loaded data that is injected into the form
	 *
	 * @param   string   $context Context of the content being passed to the plugin
	 * @param   stdClass $data    Object containing the data for the form
	 *
	 * @return  bool True if method succeeds.
	 *
	 * @since   1.0
	 */
	public function onContentPrepareData($context, $data)
	{
		// We only work on articles for now
		if (in_array($context, $this->aAllowedContext) && is_object($data) && !$this->app->isSite())
		{
			$iId = isset($data->id) ? $data->id : 0;

			if ($iId > 0)
			{
				$data->seo = $this->getSEOData($iId);
			}
		}

		return true;
	}

	/**
	 * Get record based on given value with key
	 *
	 * @param   string $sValue   The value to look for
	 * @param   string $sKey     The key of the column
	 * @param   string $sContext The context of the item
	 *
	 * @return  array the record or empty if not found
	 *
	 * @since   1.0
	 */
	private function getSEOData($sValue, $sKey = 'context_id', $sContext = 'com_content.article')
	{
		$q = $this->db->getQuery(true);

		$q
			->select(
				$this->db->quoteName(
					array(
						'pwtseo.context',
						'pwtseo.context_id',
						'pwtseo.focus_word',
						'pwtseo.pwtseo_score',
						'pwtseo.facebook_title',
						'pwtseo.facebook_description',
						'pwtseo.facebook_image',
						'pwtseo.twitter_title',
						'pwtseo.twitter_description',
						'pwtseo.twitter_image',
						'pwtseo.google_title',
						'pwtseo.google_description',
						'pwtseo.google_image',
						'pwtseo.adv_open_graph',
						'pwtseo.override_page_title',
						'pwtseo.page_title',
						'pwtseo.expand_og',
						'pwtseo.override_canonical',
						'pwtseo.canonical'
					)
				)
			)
			->from($this->db->quoteName('#__plg_pwtseo', 'pwtseo'))
			->where($this->db->quoteName('pwtseo.' . $sKey) . ' = ' . $this->db->quote($sValue))
			->where($this->db->quoteName('pwtseo.context') . ' = ' . $this->db->quote($sContext));

		try
		{
			return (array) $this->db->setQuery($q)->loadObject();
		}
		catch (Exception $e)
		{
		}

		return array();
	}

	/**
	 * When previewing an article, set the values we got from the form
	 *
	 * @param   string   $context The context of the current page
	 * @param   Object   $article The article that is prepared
	 * @param   Registry $params  Any parameters
	 * @param   string   $page    The name of the page
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onContentPrepare($context, &$article, &$params, $page)
	{
		if ($this->app->isClient('site') && $this->app->input->getInt('pwtseo_preview', 0))
		{
			$aForm = $this->app->input->post->get('jform', '', 'raw');

			foreach ($aForm as $sKey => $sValue)
			{
				if (is_array($sValue) || is_object($sValue))
				{
					$rTmp = new Registry;

					foreach ((array) $sValue as $key => $val)
					{
						$rTmp->set($key, $val);
					}

					$article->{$sKey} = $rTmp;
				}
				else
				{
					$article->{$sKey} = $sValue;
				}
			}

			// Some don't overlap, so we have to do it manually
			if (isset($aForm['articletext']) && $aForm['articletext'])
			{
				$article->text = $aForm['articletext'];
			}
		}
	}

	/**
	 * Store the score and additional info for this article
	 *
	 * @param   string $context The context of the content being passed to the plugin
	 * @param   Object $article A reference to the JTableContent object that is being saved which holds the article data
	 * @param   bool   $isNew   A boolean which is set to true if the content is about to be created
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function onContentAfterSave($context, $article, $isNew)
	{
		// Do not process internal items
		if (in_array($context, $this->aAllowedContext) && strpos($context, 'com_pwtseo') === false)
		{
			$jFilter = InputFilter::getInstance();
			$aSEO    = $this->app->input->post->get('jform', array(), 'array')['seo'];

			array_walk($aSEO, array($jFilter, 'clean'));
			$aSEO['context_id'] = $article->id;

			$oInput = (object) $aSEO;

			$oInput->version = '1.1.0';
			$oInput->context = $context;

			$iId = $this->getHasSEOData($article->id);

			if ($iId)
			{
				$oInput->id = $iId;
				$this->db->updateObject('#__plg_pwtseo', $oInput, array('id'));
			}
			else
			{
				$this->db->insertObject('#__plg_pwtseo', $oInput);
			}

		}

		return true;
	}

	/**
	 * Find record id based on com_content.article id
	 *
	 * @param   string $sValue   The value to look for
	 * @param   string $sKey     The key of the column
	 * @param   string $sContext The context of the item
	 *
	 * @return  integer|null the ID of the record or null if nothing found
	 *
	 * @since   1.0
	 */
	private function getHasSEOData($sValue, $sKey = 'context_id', $sContext = 'com_content.article')
	{
		$q = $this->db->getQuery(true);

		$q
			->select('id')
			->from($this->db->quoteName('#__plg_pwtseo', 'seodata'))
			->where($this->db->quoteName('seodata.' . $sKey) . ' = ' . $this->db->quote($sValue))
			->where($this->db->quoteName('seodata.context') . ' = ' . $this->db->quote($sContext));

		try
		{
			return $this->db->setQuery($q)->loadResult();
		}
		catch (Exception $e)
		{
		}

		return 0;
	}

	/**
	 * Handle on BeforeRender to set the page title
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function onBeforeRender()
	{
		$input = $this->app->input;

		if ($this->app->isSite())
		{
			$sId      = $input->getInt('id');
			$sKey     = 'context_id';
			$sContext = $input->getCmd('context', $input->getCmd('option') . '.' . $input->getCmd('view'));

			$iSEOId   = $this->getHasSEOData($sId, $sKey, $sContext) ?:
				$this->getHasSEOData(JUri::getInstance()->getPath(), 'url', 'com_pwtseo.custom');
			$bPreview = $input->getBool('pwtseo_preview', false);

			if ($iSEOId > 0 || $bPreview)
			{
				if ($bPreview)
				{
					$aSEO = $input->post->get('jform', '', 'raw')['seo'];
				}
				else
				{
					$aSEO = $this->getSEOData($sId, $sKey, $sContext) ?: $this->getSEOData(JUri::getInstance()->getPath(), 'url', 'com_pwtseo.custom');
				}

				if (strlen($aSEO['page_title']) && $aSEO['override_page_title'] === '1')
				{
					$title = $aSEO['page_title'];

					if ($this->app->get('sitename_pagetitles', 0) == 1)
					{
						$title = Text::sprintf('JPAGETITLE', $this->app->get('sitename'), $title);
					}
					elseif ($this->app->get('sitename_pagetitles', 0) == 2)
					{
						$title = Text::sprintf('JPAGETITLE', $title, $this->app->get('sitename'));
					}

					Factory::getDocument()->setTitle($title);
				}

				if (isset($aSEO['override_canonical']) && $aSEO['override_canonical'])
				{
					switch ((int) $aSEO['override_canonical'])
					{
						// Self referencing
						case 2:
							$this->setCanonical(Uri::getInstance());
							break;
						// Custom
						case 3:
							$this->setCanonical($aSEO['canonical']);
							break;
						// Use plugin settings
						case 1:
						default:
							if ($this->params->get('set_canonical', 1))
							{
								$this->setCanonical(Uri::getInstance());
							}
					}
				}

				if ($this->params->get('advanced_mode'))
				{
					// Handle repeatable field
					$aAdvancedFields = json_decode($aSEO['adv_open_graph']);

					if ($aAdvancedFields && isset($aAdvancedFields->og_title))
					{
						$aKeys = array_keys($aAdvancedFields->og_title);

						foreach ($aKeys as $iKey)
						{
							Factory::getDocument()->addCustomTag(
								'<meta property="' . $aAdvancedFields->og_title[$iKey] . '" content="' . $aAdvancedFields->og_content[$iKey] . '" >'
							);
						}
					}
				}
				else
				{
					if (strlen($aSEO['facebook_title']))
					{
						Factory::getDocument()->setMetaData(
							'og:title', $aSEO['facebook_title'], 'property'
						);
					}

					if (strlen($aSEO['facebook_description']))
					{
						Factory::getDocument()->setMetaData(
							'og:description', $aSEO['facebook_description'], 'property'
						);
					}

					if (strlen($aSEO['facebook_image']))
					{
						Factory::getDocument()->setMetaData(
							'og:image', Uri::base() . $aSEO['facebook_image'], 'property'
						);
					}

					if (strlen($aSEO['twitter_title']))
					{
						Factory::getDocument()->setMetaData(
							'twitter:title', $aSEO['twitter_title'], 'property'
						);
					}

					if (strlen($aSEO['twitter_description']))
					{
						Factory::getDocument()->setMetaData(
							'twitter:description', $aSEO['twitter_description'], 'property'
						);
					}

					if (strlen($aSEO['twitter_image']))
					{
						Factory::getDocument()->setMetaData(
							'twitter:image', Uri::base() . $aSEO['twitter_image'], 'property'
						);
					}

					if (strlen($aSEO['google_title']))
					{
						Factory::getDocument()->setMetaData(
							'google:title', $aSEO['google_title']
						);
					}

					if (strlen($aSEO['google_description']))
					{
						Factory::getDocument()->setMetaData(
							'google:description', $aSEO['google_description']
						);
					}

					if (strlen($aSEO['google_image']))
					{
						Factory::getDocument()->setMetaData(
							'google:image', Uri::base() . $aSEO['google_image']
						);
					}
				}
			}
			else
			{
				if ($this->params->get('set_canonical', 1))
				{
					$this->setCanonical(Uri::getInstance());
				}
			}
		}
	}

	/**
	 * Method to set the canonical url for the current page.
	 *
	 * @param   string $sUrl The url to set as canonical
	 *
	 * @return  void
	 *
	 * @since   1.0.2
	 */
	protected function setCanonical($sUrl)
	{
		Factory::getDocument()->setMetaData('canonical', htmlspecialchars($sUrl));
	}

	/**
	 * This function is called form the backend to check if the focus word is used already
	 *
	 * @return  array
	 *
	 * @since   1.0
	 */
	public function onAjaxPWTSeo()
	{
		if ($this->app->isSite())
		{
			die('Restricted Access');
		}

		$aResponse  = array('count' => 0);
		$sFocusWord = $this->app->input->getCmd('focusword', '');
		$iArticleId = $this->app->input->getInt('id', '');
		$uUrl       = $this->app->input->get('url', '', 'html');

		$q = $this->db->getQuery(true);

		$q
			->select('COUNT(*)')
			->from($this->db->quoteName('#__plg_pwtseo', 'a'))
			->where('LOWER(a.`focus_word`) = ' . $this->db->quote(strtolower($sFocusWord)))
			->where($this->db->quoteName('context_id') . ' != ' . $iArticleId);

		try
		{
			$aResponse['count'] = (int) $this->db->setQuery($q)->loadResult();
		}
		catch (Exception $e)
		{
			$aResponse['count'] = 0;
		}

		$aResponse['reachable'] = $uUrl ? $this->isReachable($uUrl) : 1;

		return $aResponse;
	}

	/**
	 * Checks if a given url is allowed by robots.txt
	 *
	 * @param   string $sUrl The url to check
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	protected function isReachable($sUrl)
	{
		jimport('joomla.filesystem.file');
		$sRobots = JPATH_ROOT . '/robots.txt';

		if (!JFile::exists($sRobots))
		{
			return true;
		}

		$aRobots = file($sRobots, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		$i       = count($aRobots);
		$sDomain = rtrim(Uri::root(), '/');

		while ($i--)
		{
			// If it's not a regular disallow directive, skip it
			if (strpos($aRobots[$i], 'Disallow:') !== 0)
			{
				continue;
			}

			list($cmd, $url) = explode(': ', $aRobots[$i]);

			if (stripos($sUrl, $sDomain . $url) !== false)
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * The resulting page is retrieved here and processed for the backend
	 *
	 * @return  object
	 *
	 * @since   1.0
	 */
	public function onAjaxPWTSEOPage()
	{
		if (!$this->app->isSite())
		{
			die('Restricted Access');
		}

		$aResponse = array();
		$aData     = $this->app->input->get('jform', array(), 'array');
		$iId       = isset($aData['id']) ?
			(int) $aData['id'] : (int) Uri::getInstance($this->app->input->get('form_url', '', 'html'))->getQuery(true)['id'];

		require_once JPATH_SITE . '/components/com_content/helpers/route.php';

		$aResponse['url']
			= substr(Uri::root(), 0, -1) .
			Route::_(ContentHelperRoute::getArticleRoute($iId, (int) $aData['catid']), false);

		// Here we modify the alias and get the route based on the given alias
		if ($iId > 0)
		{
			$db = Factory::getDbo();
			$q  = $db->getQuery(true);

			$q
				->select($db->quoteName('a.alias'))
				->from($db->quoteName('#__content', 'a'))
				->where('a.id = ' . $iId);

			try
			{
				$sOriginalAlias = $db->setQuery($q)->loadResult();
				$sModifiedAlias = OutputFilter::stringURLUnicodeSlug($aData['alias']);

				$oTmpAlias = (object) array(
					'id'    => $iId,
					'alias' => $sModifiedAlias
				);

				$db->updateObject('#__content', $oTmpAlias, array('id'));

				// We need to modify the url to circumvent the caching mechanism of the Router
				$sUniq = uniqid('pwtseo') . '=1';
				$aResponse['new_url']
				       = substr(Uri::root(), 0, -1) .
					Route::_(ContentHelperRoute::getArticleRoute($iId, (int) $aData['catid']) . '&' . $sUniq, false);

				$aResponse['new_url'] = str_replace(array('?' . $sUniq, $sUniq), '', $aResponse['new_url']);

				// Revert the change
				$oTmpAlias->alias = $sOriginalAlias;
				$db->updateObject('#__content', $oTmpAlias, array('id'));
			}
			catch (Exception $e)
			{
			}
		}

		$aResponse['reachable'] = $this->isReachable($aResponse['url']);
		$aResponse['count']     = $this->findUsages($aData['seo']['focus_word'], $iId);

		$aResponse['page_title_unique']    = $this->isTitleUnique($aData['title']);
		$aResponse['page_metadesc_unique'] = isset($aData['metadesc']) ? $this->isMetaDescriptionUnique($aData['metadesc']) : true;

		return (object) $aResponse;
	}

	/**
	 * Function that checks the database to see how many times a given word is used
	 *
	 * @param   string $sWord The word to check
	 * @param   int    $iPK   The id of the content item, this is needed to exclude current article from the count
	 *
	 * @return  int The amount of times the focus word is used
	 *
	 * @since   1.0
	 */
	protected function findUsages($sWord, $iPK)
	{
		$q     = $this->db->getQuery(true);
		$sWord = InputFilter::getInstance()->clean($sWord);

		$q
			->select('COUNT(*)')
			->from($this->db->qn('#__plg_pwtseo', 'a'))
			->where('LOWER(a.`focus_word`) = ' . $this->db->quote(strtolower($sWord)))
			->where('context_id != ' . $iPK);

		try
		{
			return (int) $this->db->setQuery($q)->loadResult();
		}
		catch (Exception $e)
		{
		}

		return 0;
	}

	/**
	 * Function to check if given title is unique across articles. For now we only check com_content
	 *
	 * @param   string $sTitle The title to check
	 *
	 * @return  bool True if title is found only once, false otherwise
	 *
	 * @since   1.0.1
	 */
	protected function isTitleUnique($sTitle)
	{
		$q = $this->db->getQuery(true);

		$q
			->select('COUNT(*)')
			->from($this->db->quoteName('#__content', 'content'))
			->where('LOWER(' . $this->db->quoteName('content.title') . ') = ' . $this->db->quote(strtolower($sTitle)));

		try
		{
			return (int) $this->db->setQuery($q)->loadResult() <= 1;
		}
		catch (Exception $e)
		{
			return true;
		}
	}

	/**
	 * Function to check if given meta description is unique across articles. For now we only check com_content
	 *
	 * @param   string $sDescription The meta description to check
	 *
	 * @return  bool True if the description is found only once, false otherwise
	 *
	 * @since   1.0.1
	 */
	protected function isMetaDescriptionUnique($sDescription)
	{
		$q = $this->db->getQuery(true);

		// TODO: Include the adv options, someone could have put a description there which is reasonable to check
		$q
			->select('COUNT(*)')
			->from($this->db->quoteName('#__content', 'content'))
			->where('LOWER(' . $this->db->quoteName('content.metadesc') . ') = ' . $this->db->quote(strtolower($sDescription)));

		try
		{
			return (int) $this->db->setQuery($q)->loadResult() <= 1;
		}
		catch (Exception $e)
		{
			return true;
		}
	}

	/**
	 * Retrieve the values of given tags for the document
	 *
	 * @param   DOMDocument $oDoc  The document which holds the tags
	 * @param   array       $aTag  An array of tags to search through
	 * @param   array       $aKeys The keys to get from the tags
	 *
	 * @return  array
	 *
	 * @since   1.0
	 */
	private function getTagValuesByKeys(DOMDocument $oDoc, $aTag, $aKeys = array())
	{
		$aReturn = array();

		foreach ((array) $aTag as $sTag)
		{
			/** @var DOMNodeList $aNodeList */
			$aNodeList = $oDoc->getElementsByTagName($sTag);

			/** @var DOMNode $oNode */
			foreach ($aNodeList as $oNode)
			{
				$aTmp = array();

				array_walk(
					$aKeys,
					function ($sKey) use (&$aTmp, $oNode)
					{
						if (isset($oNode->{$sKey}))
						{
							$aTmp[$sKey] = (string) $oNode->{$sKey};
						}
						else
						{
							$aTmp[$sKey] = (string) $oNode->getAttribute($sKey);
						}
					}
				);

				$aReturn[] = $aTmp;
			}
		}

		return $aReturn;
	}
}
