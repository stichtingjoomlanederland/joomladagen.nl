<?php
/**
 * @package     perfecttemplate
 * @copyright   Copyright (c) Perfect Web Team / perfectwebteam.nl
 * @license     GNU General Public License version 3 or later
 */

defined('_JEXEC') or die();

use Joomla\CMS\Environment\Browser;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Uri\Uri;

class PWTTemplateHelper
{
	static public function template()
	{
		return Factory::getApplication()->getTemplate();
	}

	/**
	 * Method to manually override the META-generator
	 *
	 * @access public
	 *
	 * @param   string  $generator
	 *
	 * @return null
	 *
	 * @since  PerfectSite2.1.0
	 */
	static public function setGenerator($generator)
	{
		Factory::getDocument()->setGenerator($generator);
	}

	/**
	 * Method to set some Meta data
	 *
	 * @since PerfectSite2.1.0
	 */
	static public function setMetadata()
	{
		$doc    = Factory::getDocument();
		$config = Factory::getConfig();

		$doc->setCharset('utf-8');
		$doc->setMetaData('X-UA-Compatible', 'IE=edge', true);
		$doc->setMetaData('viewport', 'width=device-width, initial-scale=1.0');
		$doc->setMetaData('mobile-web-app-capable', 'yes');
		$doc->setMetaData('apple-mobile-web-app-capable', 'yes');
		$doc->setMetaData('apple-mobile-web-app-status-bar-style', 'black');
		$doc->setMetaData('apple-mobile-web-app-title', $config->get('sitename'));
		self::setGenerator(self::getSitename());
	}

	/**
	 * Method to set Favicon
	 *
	 * @param   string $faviconColor Color for Favicon
	 *
	 * @return  void
	 * @throws  Exception
	 * @since   PerfectSite2.1.0
	 */
	static public function setFavicon($faviconColor)
	{
		$doc = Factory::getDocument();

		$doc->addHeadLink(
			'templates/' . self::template() . '/images/favicon/apple-touch-icon.png', 'apple-touch-icon', 'rel', array('sizes' => '180x180')
		);
		// $doc->addHeadLink('templates/' . self::template() . '/images/favicon/favicon-32x32.png', 'icon', 'rel', array('type' => 'image/png', 'sizes' => '32x32'));
		// $doc->addHeadLink('templates/' . self::template() . '/images/favicon/favicon-16x16.png', 'icon', 'rel', array('type' => 'image/png', 'sizes' => '16x16'));
		$doc->addHeadLink('templates/' . self::template() . '/images/favicon/site.webmanifest', 'manifest', 'rel');
		$doc->addHeadLink(
			'templates/' . self::template() . '/images/favicon/safari-pinned-tab.svg', 'mask-icon', 'rel', array('color' => $faviconColor)
		);
		$doc->addHeadLink('templates/' . self::template() . '/images/favicon/favicon.ico', 'shortcut icon', 'rel');
	}

	/**
	 * Method to return the current Menu Item ID
	 *
	 * @since PerfectSite2.1.0
	 */
	static public function getItemId()
	{
		return Factory::getApplication()->input->getInt('Itemid');
	}

	/**
	 * Method to get the current sitename
	 *
	 * @since PerfectSite2.1.0
	 */
	static public function getSitename()
	{
		return Factory::getConfig()->get('sitename');
	}

	/**
	 * Method to get wether site is in development
	 *
	 * @access public
	 *
	 * @param   string  $name  Name of last word in site title
	 *
	 * @return string
	 */
	static public function isDevelopment($name = '[dev]')
	{
		return boolval(strpos(Factory::getConfig()->get('sitename'), $name));
	}

	/**
	 * Method to fetch the current path
	 *
	 * @access public
	 *
	 * @param   string  $output  Output type
	 *
	 * @return mixed
	 * @since  PerfectSite2.1.0
	 */
	static public function getPath($output = 'array')
	{
		$uri  = URI::getInstance();
		$path = $uri->getPath();
		$path = preg_replace('/^\//', '', $path);
		if ($output == 'array')
		{
			$path = explode('/', $path);

			return $path;
		}

		return $path;
	}

	/**
	 * get PageClass set with Menu Item
	 *
	 * @return mixed
	 * @since  PerfectSite2.1.0
	 */
	static public function getPageClass()
	{
		$activeMenu = Factory::getApplication()->getMenu()->getActive();
		$pageclass  = ($activeMenu) ? $activeMenu->params->get('pageclass_sfx', '') : '';

		return $pageclass;
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	static public function getPageOption()
	{
		$input = Factory::getApplication()->input;

		return str_replace('_', '-', $input->getCmd('option', ''));
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	static public function getPageView()
	{
		$input = Factory::getApplication()->input;

		return str_replace('_', '-', $input->getCmd('view', ''));
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	static public function getPageLayout()
	{
		$input = Factory::getApplication()->input;

		return str_replace(self::template(), '', $input->getCmd('layout', ''));
	}

	/**
	 *
	 * @return mixed
	 *
	 * @since version
	 */
	static public function getPageTask()
	{
		$input = Factory::getApplication()->input;

		return str_replace('_', '', $input->getCmd('task', ''));
	}

	/**
	 * get parameter 'Show Intro Image' set with Menu Item
	 *
	 * @return mixed
	 * @since  PerfectSite2.1.0
	 */
	static public function getParam($param)
	{
		$activeMenu = Factory::getApplication()->getMenu()->getActive();
		$parameter  = ($activeMenu) ? $activeMenu->params->get($param, 1) : '';

		return $parameter;
	}

	/**
	 * Generate a list of useful CSS classes for the body
	 *
	 * @param   null
	 *
	 * @return bool
	 * @since  PerfectSite2.1.0
	 */
	static public function getBodySuffix()
	{
		$classes   = array();
		$classes[] = 'option-' . self::getPageOption();
		$classes[] = 'view-' . self::getPageView();
		$classes[] = self::getPageLayout() ? 'layout-' . self::getPageLayout() : 'no-layout';
		$classes[] = self::getPageTask() ? 'task-' . self::getPageTask() : 'no-task';
		$classes[] = 'itemid-' . self::getItemId();
		$classes[] = self::getPageClass();
		$classes[] = self::isHome() ? 'path-home' : 'path-' . implode('-', self::getPath('array'));
		$classes[] = 'home-' . (int) self::isHome();

		return implode(' ', $classes);
	}

	/**
	 * Method to determine whether the current page is the Joomla! homepage
	 *
	 * @access public
	 *
	 * @param   null
	 *
	 * @return bool
	 * @since  PerfectSite2.1.0
	 */
	static public function isHome()
	{
		// Fetch the active menu-item
		$activeMenu = Factory::getApplication()->getMenu()->getActive();

		// Return whether this active menu-item is home or not
		return (boolean) ($activeMenu) ? $activeMenu->home : false;
	}

	/**
	 * Method to determine whether the current page is the requested page
	 *
	 * @access public
	 *
	 * @param   null
	 *
	 * @return bool
	 * @since  PerfectSite2.1.0
	 */
	static public function isPage($request = 'home')
	{
		return URI::getInstance()->getPath() == $request;
	}

	/**
	 * Remove unwanted CSS
	 * @since  PerfectSite2.1.0
	 */
	static public function unloadCss()
	{
		$doc = Factory::getDocument();

		$unset_css = array('com_finder', 'com_rsform');

		foreach ($doc->_styleSheets as $name => $style)
		{
			foreach ($unset_css as $css)
			{
				if (strpos($name, $css) !== false)
				{
					unset($doc->_styleSheets[$name]);
				}
			}
		}
	}

	/**
	 * Load CSS
	 * @since  PerfectSite2.1.0
	 */
	static public function loadCss()
	{
		HTMLHelper::_('stylesheet', 'bootstrap.min.css', ['version' => 'auto', 'relative' => true]);
		HTMLHelper::_('stylesheet', 'font-awesome.min.css', ['version' => 'auto', 'relative' => true]);
		HTMLHelper::_('stylesheet', 'style.min.css', ['version' => 'auto', 'relative' => true]);
		HTMLHelper::_('stylesheet', 'https://fonts.googleapis.com/css?family=Roboto:400|Raleway:700');
	}


	/**
	 * Remove unwanted JS
	 *
	 * @return void
	 * @since  PerfectSite2.1.0
	 */
	static public function unloadJs()
	{
		$doc = Factory::getDocument();

		// Call JavaScript to be able to unset it correctly
		HTMLHelper::_('behavior.framework');
		HTMLHelper::_('bootstrap.framework');
		HTMLHelper::_('jquery.framework');
		HTMLHelper::_('bootstrap.tooltip');

		// Unset unwanted JavaScript
		unset($doc->_scripts[$doc->baseurl . '/media/system/js/mootools-core.js']);
		unset($doc->_scripts[$doc->baseurl . '/media/system/js/mootools-more.js']);
		unset($doc->_scripts[$doc->baseurl . '/media/system/js/caption.js']);
		unset($doc->_scripts[$doc->baseurl . '/media/system/js/core.js']);
		unset($doc->_scripts[$doc->baseurl . '/media/jui/js/jquery.min.js']);
		unset($doc->_scripts[$doc->baseurl . '/media/jui/js/jquery-noconflict.js']);
		unset($doc->_scripts[$doc->baseurl . '/media/jui/js/jquery-migrate.min.js']);
		unset($doc->_scripts[$doc->baseurl . '/media/jui/js/bootstrap.min.js']);
		unset($doc->_scripts[$doc->baseurl . '/media/system/js/tabs-state.js']);
		unset($doc->_scripts[$doc->baseurl . '/media/system/js/validate.js']);

		if (isset($doc->_script['text/javascript']))
		{
			$doc->_script['text/javascript'] = preg_replace(
				'%jQuery\(window\)\.on\(\'load\'\,\s*function\(\)\s*\{\s*new\s*JCaption\(\'img.caption\'\);\s*}\s*\);\s*%', '',
				$doc->_script['text/javascript']
			);
			$doc->_script['text/javascript'] = preg_replace(
				'%\s*jQuery\(function\(\$\)\{\s*[initTooltips|initPopovers].*?\}\);\}\s*\}\);%', '', $doc->_script['text/javascript']
			);

			// Unset completly if empty
			if (empty($doc->_script['text/javascript']))
			{
				unset($doc->_script['text/javascript']);
			}
		}
	}


	/**
	 * Load JS
	 *
	 * @since  PerfectSite2.1.0
	 */
	static public function loadJs()
	{
		HTMLHelper::_('script', 'templates/' . self::template() . '/js/jquery.js', array('version' => 'auto'), array('defer' => true));
		HTMLHelper::_('script', 'templates/' . self::template() . '/js/popper.min.js', array('version' => 'auto'), array('defer' => true));
		HTMLHelper::_('script', 'templates/' . self::template() . '/js/bootstrap.min.js', array('version' => 'auto'), array('defer' => true));
		HTMLHelper::_('script', 'templates/' . self::template() . '/js/jquery.appear.min.js', array('version' => 'auto'), array('defer' => true));
		HTMLHelper::_('script', 'templates/' . self::template() . '/js/jquery.jCounter.min.js', array('version' => 'auto'), array('defer' => true));
		HTMLHelper::_('script', 'templates/' . self::template() . '/js/wow.min.js', array('version' => 'auto'), array('defer' => true));
		HTMLHelper::_('script', 'templates/' . self::template() . '/js/main.min.js', array('version' => 'auto'), array('defer' => true));
	}


	/**
	 * Load custom font in localstorage
	 *
	 * @since  PerfectSite2.1.0
	 */
	static public function localstorageFont()
	{
		// Keep whitespace below for nicer source code
		$javascript = "    !function(){\"use strict\";function e(e,t,n){e.addEventListener?e.addEventListener(t,n,!1):e.attachEvent&&e.attachEvent(\"on\"+t,n)}function t(e){return window.localStorage&&localStorage.font_css_cache&&localStorage.font_css_cache_file===e}function n(){if(window.localStorage&&window.XMLHttpRequest)if(t(o))c(localStorage.font_css_cache);else{var n=new XMLHttpRequest;n.open(\"GET\",o,!0),e(n,\"load\",function(){4===n.readyState&&(c(n.responseText),localStorage.font_css_cache=n.responseText,localStorage.font_css_cache_file=o)}),n.send()}else{var a=document.createElement(\"link\");a.href=o,a.rel=\"stylesheet\",a.type=\"text/css\",document.getElementsByTagName(\"head\")[0].appendChild(a),document.cookie=\"font_css_cache\"}}function c(e){var t=document.createElement(\"style\");t.innerHTML=e,document.getElementsByTagName(\"head\")[0].appendChild(t)}var o=\"/templates/" . self::template() . "/css/font.min.css\";window.localStorage&&localStorage.font_css_cache||document.cookie.indexOf(\"font_css_cache\")>-1?n():e(window,\"load\",n)}();";
		Factory::getDocument()->addScriptDeclaration($javascript);
	}


	/**
	 * Ajax for SVG
	 *
	 * @since  PerfectSite2.1.0
	 */
	static public function ajaxSVG()
	{
		$javascript = "var ajax=new XMLHttpRequest;ajax.open(\"GET\",\"" . URI::Base() . "templates/" . self::template() . "/icons/icons.svg\",!0),ajax.send(),ajax.onload=function(a){var b=document.createElement(\"div\");b.className='svg-sprite';b.innerHTML=ajax.responseText,document.body.insertBefore(b,document.body.childNodes[0])};";
		Factory::getDocument()->addScriptDeclaration($javascript);
	}


	/**
	 * Method to detect a certain browser type
	 *
	 * @access public
	 *
	 * @param   string  $shortname
	 *
	 * @return string
	 * @since  PerfectSite2.1.0
	 */
	static public function isBrowser($shortname = 'ie6')
	{
		\JLoader::import('joomla.environment.browser');
		$browser = Browser::getInstance();

		switch ($shortname)
		{
			case 'edge':
				$rt = (stristr($browser->getAgentString(), 'edge')) ? true : false;
				break;
			case 'firefox':
			case 'ff':
				$rt = (stristr($browser->getAgentString(), 'firefox')) ? true : false;
				break;
			case 'ie':
				$rt = ($browser->getBrowser() == 'msie') ? true : false;
				break;
			case 'ie6':
				$rt = ($browser->getBrowser() == 'msie' && $browser->getVersion() == '6.0') ? true : false;
				break;
			case 'ie7':
				$rt = ($browser->getBrowser() == 'msie' && $browser->getVersion() == '7.0') ? true : false;
				break;
			case 'ie8':
				$rt = ($browser->getBrowser() == 'msie' && $browser->getVersion() == '8.0') ? true : false;
				break;
			case 'ie9':
				$rt = ($browser->getBrowser() == 'msie' && $browser->getVersion() == '9.0') ? true : false;
				break;
			case 'lteie9':
				$rt = ($browser->getBrowser() == 'msie' && $browser->getMajor() <= 9) ? true : false;
				break;
			default:
				$rt = (stristr($browser->getAgentString(), $shortname)) ? true : false;
				break;
		}

		return $rt;
	}

	/**
	 * load Analytics
	 *
	 * @param $template
	 *
	 * @return string
	 * @since  PerfectSite2.1.0
	 */
	static public function getAnalytics($analytics = null, $analyticsId = null)
	{
		$doc        = Factory::getDocument();
		$bodyScript = '';

		if (!$analyticsId)
		{
			return false;
		}

		switch ($analytics)
		{
			case 0:
				break;

			case 1:
				// Universal Google Universal Analytics - loaded in head
				$headScript = "
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '" . $analyticsId . "', 'auto');
        ga('send', 'pageview');
      ";
				$doc->addScriptDeclaration($headScript);

				break;

			case 2:
				// Google Tag Manager - party loaded in head
				$headScript = "
  <!-- Google Tag Manager -->
  (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','" . $analyticsId . "');
  <!-- End Google Tag Manager -->

          ";
				$doc->addScriptDeclaration($headScript);

				// Google Tag Manager - partly loaded directly after body
				$bodyScript = "<!-- Google Tag Manager -->
<noscript><iframe src=\"//www.googletagmanager.com/ns.html?id=" . $analyticsId . "\" height=\"0\" width=\"0\" style=\"display:none;visibility:hidden\"></iframe></noscript>
<!-- End Google Tag Manager -->
";

				break;

			case 3:
				// Mixpanel.com - loaded in head
				$headScript = "
<!-- start Mixpanel -->(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(\".\");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;\"undefined\"!==typeof d?c=b[d]=[]:d=\"mixpanel\";c.people=c.people||[];c.toString=function(b){var a=\"mixpanel\";\"mixpanel\"!==d&&(a+=\".\"+d);b||(a+=\" (stub)\");return a};c.people.toString=function(){return c.toString(1)+\".people (stub)\"};i=\"disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user\".split(\" \");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=e.createElement(\"script\");a.type=\"text/javascript\";a.async=!0;a.src=\"undefined\"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:\"file:\"===e.location.protocol&&\"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js\".match(/^\/\//)?\"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js\":\"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js\";f=e.getElementsByTagName(\"script\")[0];f.parentNode.insertBefore(a,f)}})(document,window.mixpanel||[]);
mixpanel.init(\"" . $analyticsId . "\");<!-- end Mixpanel -->
      ";
				$doc->addScriptDeclaration($headScript);

				break;

			case 4:
				// Google code for remarketing
				$bodyScript = "
<script type=\"text/javascript\">
/* <![CDATA[ */
var google_conversion_id = " . $analyticsId . ";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type=\"text/javascript\" src=\"//www.googleadservices.com/pagead/conversion.js\">
</script>
<noscript>
<div style=\"display:inline;\">
<img height=\"1\" width=\"1\" style=\"border-style:none;\" alt=\"\" src=\"//googleads.g.doubleclick.net/pagead/viewthroughconversion/" . $analyticsId . "/?guid=ON&amp;script=0\"/>
</div>
</noscript>
";

				break;

			case 5:
				// Facebook pixel
				$headScript = "<!-- Facebook Pixel Code -->
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '" . $analyticsId . "');
fbq('track', 'PageView');
<!-- End Facebook Pixel Code -->
";
				$doc->addScriptDeclaration($headScript);

				$bodyScript = "<!-- Facebook Pixel Code -->
<noscript><img height=\"1\" width=\"1\" style=\"display:none\" src=\"https://www.facebook.com/tr?id=" . $analyticsId . "&ev=PageView&noscript=1\"/></noscript>
<!-- End Facebook Pixel Code -->
";
				break;
		}

		return $bodyScript;
	}

	static public function renderHelixTitle()
	{

		$menuitem = Factory::getApplication()->getMenu()->getActive(); // get the active item

		if (!$menuitem)
		{
			return false;
		}

		$params = $menuitem->params; // get the menu params

		if (!$params->get('enable_page_title', 0))
		{
			return false;
		}

		$page_title          = $menuitem->title;
		$page_title_alt      = $params->get('page_title_alt');
		$page_subtitle       = $params->get('page_subtitle');
		$page_title_bg_color = $params->get('page_title_bg_color');
		$page_title_bg_image = $params->get('page_title_bg_image');

		$style = '';

		if ($page_title_bg_color)
		{
			$style .= 'background-color: ' . $page_title_bg_color . ';';
		}

		if ($page_title_bg_image)
		{
			$style .= 'background-image: url(' . URI::root(true) . '/' . $page_title_bg_image . ');';
		}

		if ($style)
		{
			$style = 'style="' . $style . '"';
		}

		if ($page_title_alt)
		{
			$page_title = $page_title_alt;
		}

		$output = '';

		$output .= '<div class="main__title title"' . $style . '>';
		$output .= '    <div class="title__wrapper">';

		$output .= '        <h1 class="title__text">' . $page_title . '</h1>';

		if ($page_subtitle)
		{
			$output .= '		<h2 class="title__subtext">' . $page_subtitle . '</h2>';
		}

		$output .= '    </div>';
		$output .= '</div>';

		$output .= '<jdoc:include type="modules" name="breadcrumb" style="none" />';

		return $output;

	}

	static public function youtube($url, $width = 560, $height = 315, $fullscreen = true)
	{
		parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
		$youtube = '<iframe allowtransparency="true" scrolling="no" width="' . $width . '" height="' . $height . '" src="//www.youtube.com/embed/' . $my_array_of_vars['v'] . '" frameborder="0" ' . ($fullscreen ? ' allowfullscreen' : null) . ' ></iframe>';

		return $youtube;
	}
}
