<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.log
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

/**
 * Joomla! System Logging Plugin.
 *
 * @since  1.5
 */
class PlgSystemApotheken extends JPlugin
{

    protected $app;
    protected $document;



    /**
     * Change css paths in Template based on user state
     * return bool
     */

	public function onBeforeCompileHead()
	{
        $this->app      = Factory::getApplication();
        $this->document = Factory::getDocument();
        $params = $this->params;

        $pluginParams = [
            $params->get('theme')               =>  (int) $params->get('theme_id'),
            $params->get('themeAlternative')    =>  (int) $params->get('themeAlternative_id')
        ];

        $apotheken = [
            [
                'id'    =>  1,
                'name'  =>  'Wurst Apotheke'
            ],
            [
                'id'    =>  2,
                'name'  =>  'Wurst Apotheke2'
            ],
            [
                'id'    =>  3,
                'name'  =>  'Wurst Apotheke2'
            ]
        ];
	}

    /**
     * Render the checkboxes / radio
     * return HTML
     */


	public function onAfterRender()
    {
        $app    = JFactory::getApplication();

        if($app->isClient('site'))
        {

            $stateVar = $app->getUserState( 'themeState' );
            $params = $this->params;

            $date = new DateTime();

            //$tagesID = $date->format('z')+1;

            //$timestamp = strtotime("01.01.2021 +8 hours");
            //$tagesID =  date("z", $timestamp)+1;



            $currentTime = time();

            $currentTime = strtotime('2021-10-05 07:00');

            if ($currentTime > strtotime('2021-10-05 07:59')) {
                $tagesID =  date("z", $currentTime)+1;
            }
            else{
                $tagesID =  date("z", $currentTime);
            }

            $apothekenID = ($tagesID % 21);

            if(empty($stateVar))
            {
                $stateVar = $params->get('theme');
            }

            $apothekenNeu = (array) $params->get('apotheken');

            $apothekenSortiert = [];

            $idx = 0;

            foreach($apothekenNeu as $fieldName => $value)
            {
                $idx++;
                if($idx === $apothekenID){
                    $activeApotheke = $value;
                };

                if($value->isActive == 1)
                {
                    $activeApotheke = $value;
                    break;
                }
            }

            $sHtml = $app->getBody();
            $layout = new JLayoutFile('apotheken', JPATH_ROOT .'/plugins/system/apotheken/layouts');
            $html = $layout->render($activeApotheke);

            $sHtml = str_replace('[apotheken]', $html, $sHtml);

            $app->setBody($sHtml);
        }
    }

    /**
     * Ajax Set Theme State for User
     * return bool
     */

    function onAjaxSetThemeState()
    {
        $app    = $this->app;
        $value  = $app->input->get('value', '', 'STRING');
        $app->setUserState( 'themeState', $value );
        return true;
    }

    /**
     * Replace the child theme string
     * return string
     */

    function replaceStringBetween($string, $start, $end, $toReplace){

        $this->app      = Factory::getApplication();
        $userThemeState = $this->app->getUserState( 'themeState' );
        $params = $this->params;
        if(empty($userThemeState))
        {
            $userThemeState = $params->get('theme');
        }
        if(!strpos($string,'yootheme_' , 0)){
            $replacedString = $string;
            return $replacedString;
        }
        else if(strpos($string,'custom' , 0)){
            $replacedString = str_replace('yootheme_' . $params->get('theme'), 'yootheme_' . $userThemeState, $string);
            return $replacedString;
        }
        else {
            $string = " " . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return false;
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            $foundString = substr($string, $ini, $len);
            $replacedString = str_replace($foundString, $toReplace, $string);
            return $replacedString;
        }
    }

}
