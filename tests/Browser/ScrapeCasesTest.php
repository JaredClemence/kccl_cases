<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\KernCountySearchPage;
use Tests\Browser\Pages\CriminalCalendarPage;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Carbon\Carbon;
use App\ScrapeResult;

const SATURDAY = 6;
const SUNDAY = 0;

class ScrapeCasesTest extends DuskTestCase {

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testScrape() {
        $scrapeResult = new ScrapeResult();
        $scrapeResult->initializeEmptyResult();
        $date = new Carbon();

        for ($i = 0; $i < 14; $i++) {
            $this->browse(function (Browser $browser) use ($scrapeResult, $date) {
                /* @var $date Carbon */
                $browser->visit(new KernCountySearchPage())
                        ->setDate($date)
                        ->selectAllCourts()
                        ->clickSearch()
                        ->on(new CriminalCalendarPage())
                        ->scrapeCases($scrapeResult);
            });
            do{
                $date->addDay();
            }while( $date->format('w') == SATURDAY || $date->format('w') == SUNDAY );
        }
        
        $scrapeResult->store();
    }

}
