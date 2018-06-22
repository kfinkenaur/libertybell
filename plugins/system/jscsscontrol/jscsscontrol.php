<?php
/**
 * @Copyright
 * @package     JCC - JS CSS Control for Joomla! 3.x
 * @author      Viktor Vogel <admin@kubik-rubik.de>
 * @version     3.2.0 - 2016-02-05
 * @link        https://joomla-extensions.kubik-rubik.de/jcc-js-css-control
 *
 * @license     GNU/GPL
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
defined('_JEXEC') or die('Restricted access');

class PlgSystemJsCssControl extends JPlugin
{
	protected $debug;
	protected $request;
	protected $execute = true;
	protected $debug_js = array();
	protected $debug_css = array();
	protected $exclude_js_files = array();
	protected $exclude_css_files = array();
	protected $excluded_files = array();

	function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage('plg_system_jscsscontrol', JPATH_ADMINISTRATOR);

		if($this->params->get('execute_admin', 0) == false AND JFactory::getApplication()->isAdmin())
		{
			$this->execute = false;
		}

		$this->request = JFactory::getApplication()->input;
		$this->debug = $this->params->get('debug', 0);
	}

	/**
	 * Does the first check before the head section is compiled
	 */
	public function onBeforeCompileHead()
	{
		if(!empty($this->execute))
		{
			$document = JFactory::getDocument();
			$js = json_decode($this->params->get('js_list'), true);
			$css = json_decode($this->params->get('css_list'), true);
			$remove_jcaption = $this->params->get('remove_jcaption');

			// Exclude JavaScript files
			if(!empty($js))
			{
				$this->exclude_js_files = $this->getFilesToExclude($js);
			}

			// Remove caption.js if corresponding option selected
			if(!empty($remove_jcaption))
			{
				$this->exclude_js_files[] = 'media/system/js/caption.js';
			}

			if(!empty($this->exclude_js_files))
			{
				$loaded_files_js = $document->_scripts;
				$document->_scripts = $this->excludeFilesOnBeforeCompileHead($this->exclude_js_files, $loaded_files_js);
			}

			// Exclude CSS files
			if(!empty($css))
			{
				$this->exclude_css_files = $this->getFilesToExclude($css);
			}

			if(!empty($this->exclude_css_files))
			{
				$loaded_files_css = $document->_styleSheets;
				$document->_styleSheets = $this->excludeFilesOnBeforeCompileHead($this->exclude_css_files, $loaded_files_css);
			}

			if(!empty($this->debug))
			{
				// Set the placeholder for the parameters output which will be replaced in OnAfterRender
				JFactory::getApplication()->enqueueMessage('PLG_JSCSSCONTROL_DEBUGOUTPUTPLACEHOLDER');

				// Get all files which could be retrieved directly from the JDocument object
				if(!empty($loaded_files_js))
				{
					$this->debug_js = array_keys($loaded_files_js);
				}

				if(!empty($loaded_files_css))
				{
					$this->debug_css = array_keys($loaded_files_css);
				}

				$css = '.jcc-summary{font-weight: bolder;}'."\n";
				$css .= '.jcc-loaded{color: green;}'."\n";
				$css .= '.jcc-excluded{color: red;}';
				JFactory::getDocument()->addStyleDeclaration($css);
			}
		}
	}

	/**
	 * Gets all files which have to be excluded on the loaded page
	 *
	 * @param array $data Data which were entered from the user in the settings of the plugin
	 *
	 * @return array $exclude_files Filtered array with all files which have to be excluded on the called page
	 */
	private function getFilesToExclude($data)
	{
		$exclude_files = array();

		if(!empty($data['files']))
		{
			foreach($data['files'] as $key => $item)
			{
				if(!empty($data['execution'][$key]))
				{
					if(!$this->checkExecutionStatus($data['execution'][$key], $data['toggle'][$key]))
					{
						continue;
					}
				}

				$exclude_files[] = $item;
			}
		}

		return $exclude_files;
	}

	/**
	 * Checks entered parameters whether the file has to be excluded on the specific page
	 *
	 * @param string $parameters Parameters of a specific page retrieved from the debug mode
	 * @param bool   $toggle     Toggle flag to flip the execution logic
	 *
	 * @return bool
	 */
	private function checkExecutionStatus($parameters, $toggle = false)
	{
		$return = true;
		$parameters_array = array_map('trim', explode(',', $parameters));

		foreach($parameters_array as $parameter)
		{
			$parameter_array = array_map('trim', explode('=', $parameter));

			if(empty($parameter_array[1]) OR $this->request->get($parameter_array[0], '', 'raw') != $parameter_array[1])
			{
				$return = false;
				break;
			}
		}

		if(!empty($toggle))
		{
			$return = !$return;
		}

		return $return;
	}

	/**
	 * Excludes the files from being loaded before head section is compiled - OnBeforeCompileHead
	 *
	 * @param array $exclude_files Files which have to be excluded
	 * @param array $loaded_files  All files which were loaded
	 *
	 * @return array
	 */
	private function excludeFilesOnBeforeCompileHead(&$exclude_files, $loaded_files)
	{
		$loaded_files_keys = array_keys($loaded_files);

		foreach($loaded_files_keys as $loaded_file)
		{
			foreach($exclude_files as $exclude_file)
			{
				if(preg_match('@'.preg_quote($exclude_file).'@', $loaded_file))
				{
					unset($loaded_files[$loaded_file]);
					$this->excluded_files[] = $loaded_file;
					break;
				}
			}
		}

		return $loaded_files;
	}

	/**
	 * Checks the output to remove also files from the template and other extensions directly from the HTML output code
	 */
	public function onAfterRender()
	{
		if(!empty($this->execute))
		{
			$body = JFactory::getApplication()->getBody();
			$remove_jcaption = $this->params->get('remove_jcaption');
			$remove_tooltip = $this->params->get('remove_tooltip');
			$js_pattern = '@<script[^>]*src=["|\']([^>]*\.js)(\?[^>]*)?["|\'][^>]*/?>.*</script>@isU';
			$css_pattern = '@<link[^>]*href=["|\']([^>]*\.css)(\?[^>]*)?["|\'][^>]*/?>@isU';

			if(!empty($this->exclude_js_files))
			{
				$this->excludeFilesOnAfterRender($body, $this->exclude_js_files, $js_pattern);
			}

			if(!empty($this->exclude_css_files))
			{
				$this->excludeFilesOnAfterRender($body, $this->exclude_css_files, $css_pattern);
			}

			if(!empty($remove_jcaption))
			{
				$jcaption_pattern = '@<head>.*<script type="text/javascript">.*(jQuery\(window\)\.on\(\'load\',\s*function\(\)\s*{\s*\n?\s*new JCaption\(["|\']img.caption["|\']\);.*}\);).*</script>.*</head>@isU';
				$this->removeInlineJavaScript($body, $jcaption_pattern);
			}

			if(!empty($remove_tooltip))
			{
				$tooltip_pattern = '@<head>.*<script type="text/javascript">.*(jQuery\(document\)\.ready\(function\(\){\s*\n?\s*jQuery\(\'\.hasTooltip\'\)\.tooltip.*}\);.*}\);).*</script>.*</head>@isU';
				$this->removeInlineJavaScript($body, $tooltip_pattern);
			}

			if(!empty($this->debug))
			{
				if(empty($matches_js[1]))
				{
					preg_match_all($js_pattern, $body, $matches_js);
				}

				if(empty($matches_css[1]))
				{
					preg_match_all($css_pattern, $body, $matches_css);
				}

				$debug_js_files = array_unique(array_merge($this->debug_js, $matches_js[1]));
				$debug_css_files = array_unique(array_merge($this->debug_css, $matches_css[1]));
				$debug_output_list = JTEXT::_('PLG_JSCSSCONTROL_DEBUGOUTPUT_NOFILES');

				if(!empty($debug_js_files) OR !empty($debug_css_files))
				{
					$debug_output_list = '';

					if(!empty($debug_js_files))
					{
						$debug_output_list .= $this->createDebugParametersOutput($debug_js_files, 'js');
					}

					if(!empty($debug_css_files))
					{
						$debug_output_list .= $this->createDebugParametersOutput($debug_css_files, 'css');
					}
				}

				$debug_output_parameters = $this->getDebugInformation();
				$body = str_replace('PLG_JSCSSCONTROL_DEBUGOUTPUTPLACEHOLDER', JTEXT::sprintf('PLG_JSCSSCONTROL_DEBUGOUTPUT', $debug_output_parameters, $debug_output_list), $body);
			}

			JFactory::getApplication()->setBody($body);
		}
	}

	/**
	 * Excludes the files from being loaded after output was rendered - OnAfterRender
	 *
	 * @param string $body          The whole output after everything is loaded
	 * @param array  $exclude_files Files which should be excluded
	 * @param        $pattern       $matches       All found files in the output string
	 */
	private function excludeFilesOnAfterRender(&$body, &$exclude_files, $pattern)
	{
		preg_match_all($pattern, $body, $matches);

		foreach($matches[0] as $key => $match)
		{
			foreach($exclude_files as $exclude_file)
			{
				if(preg_match('@'.preg_quote($exclude_file).'@', $match))
				{
					$body = str_replace($match, '', $body);
					$this->excluded_files[] = $matches[1][$key];
					break;
				}
			}
		}
	}

	/**
	 * Removes inline Javascript code from being loaded - OnAfterRender
	 *
	 * @param string $body    The whole output after everything is loaded
	 * @param string $pattern Pattern of the JavaScript code which has to be removed
	 */
	private function removeInlineJavaScript(&$body, $pattern)
	{
		preg_match($pattern, $body, $match);

		if(!empty($match[1]))
		{
			$body = str_replace($match[1], '', $body);
		}
	}

	/**
	 * Creates the output with all files and their sizes for the debug mode
	 *
	 * @param array  $debug_files
	 * @param string $type
	 *
	 * @return string
	 */
	private function createDebugParametersOutput($debug_files, $type)
	{
		$debug_output_array = array();
		$size_total = 0;
		$size_loaded = 0;
		$size_excluded = 0;

		foreach($debug_files as $debug_file)
		{
			$debug_file_path = $debug_file;

			// Check and adjust the path to the file to get the correct size
			if(strpos($debug_file, JURI::base()) !== false)
			{
				$debug_file_path = str_replace(JURI::base(), '', $debug_file);
			}
			elseif(strpos($debug_file, JURI::base(true)) !== false)
			{
				$debug_file_path = str_replace(JURI::base(true), '', $debug_file);
			}

			if(substr($debug_file_path, 0, 1) != '/' AND substr($debug_file_path, 0, 4) != 'http')
			{
				$debug_file_path = '/'.$debug_file_path;
			}

			if(stripos($debug_file_path, '?') !== false)
			{
				$debug_file_path = preg_replace('@\?.*$@isU', '', $debug_file_path);
			}

			$size_raw = 0;

			if(substr($debug_file_path, 0, 4) != 'http' AND file_exists(JPATH_BASE.$debug_file_path))
			{
				$size_raw = @filesize(JPATH_BASE.$debug_file_path) / 1024;
			}

			$size_total += $size_raw;

			if(!in_array($debug_file, $this->excluded_files))
			{
				$debug_output_array[] = '<span class="jcc-loaded">'.$debug_file.' - '.$this->formatSizeKb($size_raw).'</span>';
				$size_loaded += $size_raw;
			}
			else
			{
				$debug_output_array[] = '<span class="jcc-excluded">'.$debug_file.' - '.$this->formatSizeKb($size_raw).'</span>';
				$size_excluded += $size_raw;
				unset($this->excluded_files[array_search($debug_file, $this->excluded_files)]);
			}
		}

		return '<p class="jcc-summary">'.JTEXT::sprintf('PLG_JSCSSCONTROL_DEBUGOUTPUT_SUMMARY', strtoupper($type), count($debug_output_array), $this->formatSizeKb($size_total), '<span class="jcc-excluded">'.$this->formatSizeKb($size_excluded).'</span>', '<span class="jcc-loaded">'.$this->formatSizeKb($size_loaded).'</span>').'</p><pre><code>'.implode('<br />', $debug_output_array).'</code></pre>';
	}

	/**
	 * Formats the size to 2 decimals and add string _KB
	 *
	 * @param float $size
	 *
	 * @return string
	 */
	private function formatSizeKb($size)
	{
		return number_format($size, 2, ',', '.').' KB';
	}

	/**
	 * Generates parameter information for the debug mode
	 *
	 * @return string String with all needed information of the called page
	 */
	private function getDebugInformation()
	{
		$uri = JUri::getInstance();
		$debug_output = '';

		if(JFactory::getApplication()->isSite())
		{
			$debug_array = array_filter(JRouter::getInstance('site')->parse($uri));
		}
		else
		{
			$debug_output = str_replace('&', ',', $uri->getQuery());

			if(empty($debug_output))
			{
				$debug_array['option'] = $this->request->getWord('option');
				$debug_array['view'] = $this->request->getWord('view');
				$debug_array['layout'] = $this->request->getWord('layout');
				$debug_array = array_filter($debug_array);
			}
		}

		if(!empty($debug_array))
		{
			$debug_output = array();

			foreach($debug_array as $key => $value)
			{
				if(!empty($value))
				{
					$debug_output[] = $key.'='.$value;
				}
			}

			$debug_output = implode(',', $debug_output);
		}

		return $debug_output;
	}
}
