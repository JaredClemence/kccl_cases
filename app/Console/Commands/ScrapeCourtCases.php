<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Tests\Browser\ScrapeCasesTest;

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
        $test = new ScrapeCasesTest();
        $test->prepare();
        $test->testScrape();
    }
}
