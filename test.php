<?php

$loader = require 'vendor/autoload.php';
//$loader->add('Sitebase\\LimburgAfvalkalender', __DIR__ . '/src');
include "src/Scraper.php";
include "src/Export.php";

$scraper = new Sitebase\LimburgAfvalkalender\Scraper();
$export = new Sitebase\LimburgAfvalkalender\Export();

$calendar = [];
for($i=1 ; $i < 13 ; $i++) {
    $calendar = array_merge( $calendar, $scraper->getMonth($i));
}

$ical = $export->iCal($calendar);
file_put_contents('export.ics', $ical);

echo "done";
