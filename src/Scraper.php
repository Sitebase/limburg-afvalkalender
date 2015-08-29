<?php

namespace Sitebase\LimburgAfvalkalender;

use Zend\Dom\Query;
use Eluceo\iCal\Component;

class Scraper {
    private $keywordMapper = [

        // collecting events
        'huisvuil'                  => 'huisvuil',
        'pmd'                       => 'pmd',
        'tuin- en snoeiafval'       => 'tuin',
        'grofvuil'                  => 'grofvuil',
        'papier/karton'             => 'papier',
        'textiel'                   => 'textiel',

        // other events
        'nieuwjaarsborrel'          => 'nieuwjaarsborrel',
        'kerstboomverbranding'      => 'kerstboomverbranging',
        'bedeling huisvuilzakken'   => 'bedeling huisvuilzakken',
        'carnavalstoet oostham'     => 'carnaval'

    ];

    public function getMonth( $month )
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthName = isset($months[$month-1]) ? $months[$month-1] : null;
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, date('Y'));

        // invalid month number provided
        if( !$monthName )
            return null;

        $source_format = "http://www.limburg.net/afvalkalender/71069/2977/15/0/01+{{ month }}+2015/{{ daysInMonth }}+{{ month }}+2015";
        //$source_format = realpath(dirname(__FILE__) . '/..') . '/test/assets/{{ month }}-example.html';
        $source_uri = str_replace(['{{ month }}', '{{ daysInMonth }}'], [$monthName, $daysInMonth], $source_format);

        $dom = $this->fetchAsDOM($source_uri);
        return $this->parse($dom, $month);
    }

    private function parse( $dom, $monthNumber )
    {
        $month = [];
        $days = $dom->execute('.dag_container');

        // loop over days
        foreach ($days as $day) {

            // add day to month array
            $dayNumber = $day->childNodes->item(0)->textContent;
            $date = date('Y') . '-' . $monthNumber . '-' . $dayNumber;
            $month[$date] = [];

            // extra keywords
            $dayKeywords = strtolower( $day->textContent ); // make lower case to make less error prone

            // loop over know keywords and check if they are present
            foreach( $this->keywordMapper as $keyword => $name ) {
                if( strstr($dayKeywords, $keyword) )
                    $month[$date][] = $name;
            }
        }
        return $month;
    }

    private function fetchAsDOM( $uri )
    {
        $html = file_get_contents($uri);
        return new Query($html);
    }
}
