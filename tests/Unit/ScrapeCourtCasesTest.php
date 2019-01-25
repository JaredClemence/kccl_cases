<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScrapeCourtCasesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testScrape()
    {
        $data = [
            'search_dt'=>'01/25/2019',
            'courtorgloc'=>'all',
            'hdnFld1'=>'yes',
            'sortby'=>'Name',
            'Submit'=>'Search'
        ];
        $url = 'https://www.kerncounty.com/superiorcourt/crim_index_case_info_cal.asp';
        $resultsSearch = 'https://www.kerncounty.com/SuperiorCourt/crimcal/crim_index_case_cal_date_results.asp';
        $firstResponse = $this->get( $url );
        $sessionCookie = $firstResponse->baseResponse->original;
        dd( $sessionCookie );
        $response = $this->post( $resultsSearch, $data, $headers );
        $body = $response->baseResponse->content();
        dd( $body );
    }
}
