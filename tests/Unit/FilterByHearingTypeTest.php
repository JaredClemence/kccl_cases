<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\CaseCollection;
use App\CourtCase;
use App\CourtCollection;
use App\CourtDateCollection;

class FilterByHearingTypeTest extends TestCase
{
    const TESTCASE_COUNT = 3;
    const OTHER_COUNT = 5;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCaseCollection()
    {
        $collection = $this->makeTestCaseCollection();
        $this->runTestsOnContainer($collection);
    }
    
    public function testCourtDateCollection(){
        $collection = $this->makeCourtDateCollection();
        $this->runTestsOnContainer($collection);
    }
    
    private function runTestsOnContainer( $collection ){
        $this->assertEquals( 8, $collection->count() );
        
        $filtered = $collection->filterByHearingType('TestCase');
        $this->assertEquals( self::TESTCASE_COUNT, $filtered->count() );
        $this->assertNotEquals( $filtered, $collection );
        $this->assertEquals( 8, $collection->count() );
    }
    
    public function testCourtCollection(){
        $courtCollection = $this->makeCourtCollection();
        $this->runTestsOnContainer($courtCollection);
    }

    private function makeTestCaseCollection() {
        $target_cases = factory( CourtCase::class, self::TESTCASE_COUNT )->make( ['hearingType'=>'TestCaseA'] );
        $other_cases = factory( CourtCase::class, self::OTHER_COUNT )->make();
        $caseCollection = new CaseCollection();
        $target_cases->each( function( $case ) use ( $caseCollection ){
            $caseCollection->addCase( $case );
        } );
        $other_cases->each( function( $case ) use ( $caseCollection ){
            $caseCollection->addCase( $case );
        } );
        return $caseCollection;
    }

    public function makeCourtCollection() {
        $cases = $this->makeTestCaseCollection();
        $court = new CourtCollection();
        $cases->each( function( $case ) use ( $court ) {
            $court->addCase( $case );
        } );
        return $court;
    }

    private function makeCourtDateCollection() {
        $cases = $this->makeTestCaseCollection();
        $court = new CourtDateCollection();
        $cases->each( function( $case ) use ( $court ) {
            $court->addCase( $case );
        } );
        return $court;
    }

}
