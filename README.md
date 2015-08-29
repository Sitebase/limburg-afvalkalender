# Limburg.net afvalkalender scraper

Frustrated by the fact that Limburg doesn't seem to have a iCal format, or any other importable format of their afvalkalenders, I decided to create a simple scraper for [limburg.net](http://limburg.net). The initial goal is to create a custom iCal file from the scraped data that I then can use to import it into my Google calendar.

The source that I use [for scraping is](http://www.limburg.net/afvalkalender).

_If any of the devs/webmasters of limburg.net reads this, feel free to implement this on your website._

__Keep in mind that this is work in progress__

## How to use

For the moment you can use this to generate an iCal version of the afvalkalender for the current year.
First you need to do some configuration to get this working:

* Go to the [afvalkalender website](http://www.limburg.net/afvalkalender) and fill in your address.
* You will end up on an URL like this:

> http://www.limburg.net/afvalkalender/71069/2977/15/0/01+Jan+2015/31+Jan+2015

* Copy the first 3 numbers in the url, in this case `71069/2977/15` and replace them in the `src/Scraper.php` file on line `37`.
* Now run `php test.php` and this will generate an `export.ics` file in the root.
