<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Tests\Browser\ScrapeCasesTest;

use Tests\Browser\Pages\CriminalCalendarPage;
use App\ScrapeResult;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ScrapeCourtCases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uses ChromeDriver to scrape cases from Kern County Criminal Database through the web interface.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->scrape( 14 );
//        $test = new ScrapeCasesTest();
//        $test->prepare();
//        $test->testScrape();
    }
    
    public function scrape( $dayCount ){
        $date = new Carbon("now", new \DateTimeZone("America/Los_Angeles"));
        $result = new ScrapeResult();
        $result->initializeEmptyResult();
        $this->manuallyProcessRequest($date, $result);
    }
    
    public function manuallyProcessRequest( Carbon $date, ScrapeResult $result ){
        $cases = $this->scrapeCasesForDate( $date );
        $cases->each( function( $case ) use ($result ){
            $result->addCase($case);
        } );
    }

    public function scrapeCasesForDate(Carbon $date) : Collection {
        $resultHtml = $this->getFormResult( $date );
    }

    public function getFormResult( Carbon $date) {
        $page = new CriminalCalendarPage();
        $url = $page->url();
        $url = "https://www.kerncounty.com/SuperiorCourt/crimcal/crim_index_case_cal_date_results.asp";
        $data = [
            'search_dt' => $date->format('m/d/Y'),
            'courtorgloc' => 'all',
            'hdnFld1' => 'yes',
            'sortby' => 'Name',
            'Submit' => 'Search'
        ];
        $headers = [
            'User-Agent: KCCL/Web_Bot',
            'Upgrade-Insecure-Requests: 1',
            'Referer: https://www.kerncounty.com/SuperiorCourt/crim_index_case_info_cal.asp',
            'Origin: https://www.kerncounty.com',
            'Host: www.kerncounty.com',
            'Cookie: _ga=GA1.2.1127793916.1547603327; __atuvc=1%7C3; __atssc=google%3B1; nmstat=1547603423934; ASPSESSIONIDAGRSDSCT=MDKBPKMBDFKPLIEKBFEFJGDF',
            'Content-Type: application/x-www-form-urlencoded',
            'Connection: keep-alive',
            'Cache-Control: max-age=0',
            'Accept-Language: en-US,en;q=0.9',
            'Accept-Encoding: gzip, deflate, br',
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8'
        ];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        curl_close($curl);
        dd( $result );
        return $result;
    }

}
