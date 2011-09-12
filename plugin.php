<?php
/**
 * GoogleAnalyticsErr Omeka plugin.
 *
 * This plug-in allows you to paste in the JavaScript for Google Analytics and 
 * outputs it on the bottom of every public page.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at http://www.apache.org/licenses/LICENSE-2.0 Unless required by
 * applicable law or agreed to in writing, software distributed under the
 * License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS
 * OF ANY KIND, either express or implied. See the License for the specific
 * language governing permissions and limitations under the License.
 *
 * @package omeka
 * @subpackage GoogleAnalyticsErr
 * @author Eric Rochester (erochest@gmail.com)
 * @copyright 2011
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @version 0.1
 * @link http://www.ericrochester.com/
 *
 */

// {{{ Constants
define(
    'GOOGLE_ANALYTICS_ERR_PLUGIN_VERSION',
    get_plugin_ini('GoogleAnalyticsErr', 'version')
);
define(
    'GOOGLE_ANALYTICS_ERR_PLUGIN_DIR',
    dirname(__FILE__)
);
// }}}

/**
 * Add hooks for various events.
 */
// {{{ Hooks
add_plugin_hook('install', 'googleanalysticserr_install');
add_plugin_hook('uninstall', 'googleanalysticserr_uninstall');
add_plugin_hook('public_theme_footer',
                'googleanalyticserr_append_code');
add_plugin_hook('config', 'googleanalyticserr_config');
add_plugin_hook('config_form', 'googleanalyticserr_config_form');
// }}}

/**
 * Install the plugin by setting the options.
 */
function googleanalysticserr_install()
{
  set_option(
      'googleanalyticserr_version',
      GOOGLE_ANALYTICS_ERR_PLUGIN_VERSION
    );
}

/**
 * Uninstall the plugin by deleting the options.
 */
function googleanalysticserr_uninstall()
{
  delete_option('googleanalyticserr_version');
  delete_option('googleanalyticserr_code');
}

/**
 * Save data from the the plugin configuration form.
 */
function googleanalyticserr_config()
{
  set_option(
      'googleanalyticserr_code',
      trim($_POST['googleanalyticserr_code'])
  );
}

/**
 * Show the plugin configuration form.
 */
function googleanalyticserr_config_form()
{
  echo '<div id="googleanalyticserr_form">';
  echo __v()->formLabel('googleanalyticserr_code', 'Your Google Analytics code:');
  echo __v()->formTextarea(
        'googleanalyticserr_code', 
        get_option('googleanalyticserr_code'),
        array('rows' => '15', 'cols' => '80')
  );
  echo '</div>';

  // Now for some instructions. We're user friendly!
  echo '<p>To find your Google Analytics code, follow these steps:</p>';
  echo '<ol style="list-style: decimal inside;">';
  echo '<li>log onto your ';
  echo '<a href="https://www.google.com/analytics/" target="_blank">';
  echo 'Google Analytics</a> account;</li>';
  echo '<li>click "Edit" for the profile you want to use;</li>';
  echo '<li>click "Check Status";</li>';
  echo '<li>Follow the instructions, and copy and paste the text labelled ';
  echo '"Paste this code on your site"; and</li>';
  echo '<li>Paste the code into the box above.</li>';
  echo '</ol>';
}

/**
 * Show the code on the page, if it's set.
 */
function googleanalyticserr_append_code()
{
  $code = get_option('googleanalyticserr_code');
  if (isset($code) && $code !== '') {
    echo $code;
  }
}

?>

