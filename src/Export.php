<?php

namespace Sitebase\LimburgAfvalkalender;

class Export {

    public function iCal( $data )
    {
        $vCalendar = new \Eluceo\iCal\Component\Calendar('www.limburg.net');
        foreach($data as $date => $events) {
            if( !count($events) )
                continue;

            $vEvent = new \Eluceo\iCal\Component\Event();
            $vEvent
                ->setDtStart(new \DateTime($date))
                ->setDtEnd(new \DateTime($date))
                ->setNoTime(true)
                ->setSummary( implode(' en ', $events) );
            $vCalendar->addComponent($vEvent);
        }
        return $vCalendar->render();
    }

}
