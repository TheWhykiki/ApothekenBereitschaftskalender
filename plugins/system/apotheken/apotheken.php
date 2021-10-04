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


            // Aktuelle Uhrzeit holen

            $currentTime = time();

            // Nach 8h --> Tages ID Heute +1
            // Tages ID = Nummer des Tages 1-365

            if ($currentTime > strtotime('07:59')) {
                $tagesID =  date("z", $currentTime)+1;
            }
            else{
                $tagesID =  date("z", $currentTime);
            }

            // Zum testen und Datum einstellen
            /*
            $currentTime = strtotime('2021-10-10 07:00');

            if ($currentTime > strtotime('2021-10-10 07:59')) {
                $tagesID =  date("z", $currentTime)+1;
            }
            else{
                $tagesID =  date("z", $currentTime);
            }*/

            // Apotheken ID setzen, welchhe Apotheke ist dran?
            // Apotheken wechseln alle 21 Tage, daher TagesID modulo 21 um die ID zu bekommen

            $apothekenID = ($tagesID % 21);

            // Apotheken aus dem Subform Feld in den Plugin Params holen

            $apothekenNeu = (array) $params->get('apotheken');

            $idx = 0;

            foreach($apothekenNeu as $fieldName => $value)
            {
                $idx++;
                //idx = Apotheken ID aus der DB
                //wenn idx und apothekenID gleich, dann setze die aktive Apotheke
                if($idx === $apothekenID){
                    $activeApotheke = $value;
                };

                //Fallback, wenn Apotheken Dienste tauschen
                // wenn eine Apotheke den Schalter auf "ein" hat, dann wird diese angezeigt.
                // schaltet man den Schalter mehrere Male ein, dann wird nur die letzte "geschaltete" als aktiv gesetzt

                if($value->isActive == 1)
                {
                    $activeApotheke = $value;
                    break;
                }
            }

            // das komplette HTML holen nach dem Rendern und nun bearbeiten

            $sHtml = $app->getBody();

            // Layout setzen, das geladen werden soll

            $layout = new JLayoutFile('apotheken', JPATH_ROOT .'/plugins/system/apotheken/layouts');
            $html = $layout->render($activeApotheke);

            // shortcode setzen: es wird nach dem Code [apotheken] im HTML gesucht und dieser wird durch das
            // Layout ersetzt

            $sHtml = str_replace('[apotheken]', $html, $sHtml);

            $app->setBody($sHtml);
        }
    }
}
