<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Carbon\Carbon;
use \Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebElement;

class KernCountySearchPage extends Page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return 'https://www.kerncounty.com/SuperiorCourt/crimcal/crim_index_case_cal_date_results.asp';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertSee('Criminal Case Information and Calendar')
                ->assertSee('Search')
                ->assertSee('Other Searches');
    }
    
    public function setDate( Browser $browser, Carbon $date ){
        $browser->value( '@selectDate', $date->format("m/d/Y") );
    }
    
    public function selectAllCourts(Browser $browser){
        $browser->select( '@selectCourt', 'all' );
    }
    
    public function clickSearch(Browser $browser){
        $by = WebDriverBy::cssSelector('input[type=submit]');
        $elements = $browser->driver->findElements($by);
        $secondSearch = $elements[1];
        /* @var $secondSearch RemoteWebElement */
        $secondSearch->click();
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@selectCourt' => 'select[name=courtorgloc]',
            '@selectDate' => 'input[name=search_dt]',
            '@searchBtn' => 'form[name=form3] input[type=submit]'
        ];
    }
}
