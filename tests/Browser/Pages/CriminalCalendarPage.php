<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Illuminate\Support\Collection;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\WebDriverBy;
use App\ScrapeResult;
use App\CourtCase;
use Carbon\Carbon;

class CriminalCalendarPage extends Page
{
    /** @var Browser */
    private $browser;

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
        $browser->assertSee('Criminal Calendar');
    }
    
    public function scrapeCases(Browser $browser, ScrapeResult $result ){
        $this->setBrowser( $browser );
        $table = $this->findDataTable();
        if( $table ){
            $collection = $this->scrapeDataFromTableOfCases( $table );
            $this->addToScrapeResult( $collection, $result );
        }
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }

    private function setBrowser($browser) {
        $this->browser = $browser;
    }

    private function findDataTable() {
        $tables = $this->getAllTablesOnPage();
        $tableOrNull = $this->reduceTablesToRemoteWebElement( $tables );
        return $tableOrNull;
    }
    
    private function reduceTablesToRemoteWebElement( Collection $tables ){
        $dataTables = $this->findAllTablesWithRequiredHeaders( $tables );
        $tableOrNull = $this->reduceSelectedTablesToChildElement( $dataTables );
        return $tableOrNull;
    }
    
    private function findAllTablesWithRequiredHeaders( Collection $tables ){
        $hasRequiredTextTest = $this->getHasRequiredHeaderTextTest();
        //dd( $textCollection );
        $dataTables = $tables->filter( $hasRequiredTextTest );
        return $dataTables;
    }
    
    private function reduceSelectedTablesToChildElement( Collection $tables ){
        $target = $tables->reduce( function( $carryforward, $element ){
            $text = $element->getText();
            $length = strlen( $text );
            $obj = (object)compact( 'text','length','element' );
            if( $carryforward === null || $obj->length <= $carryforward->length){
                $carryforward = $obj;
            }
            return $carryforward;
        } );
        $selection = null;
        if( $target ) $selection = $target->element;
        return $selection;
    }

    private function getAllTablesOnPage() : Collection {
        $selector = WebDriverBy::tagName('table');
        $remoteElementArray = $this->browser->driver->findElements($selector);
        $remoteElementCollection = collect( $remoteElementArray );
        return $remoteElementCollection;
    }

    private function addToScrapeResult(Collection $collection, ScrapeResult $result) {
        $collection->each( function( $courtCase ) use ($result ){
            $result->addCase( $courtCase );
        } );
    }

    private function scrapeDataFromTableOfCases(RemoteWebElement $table) {
        $rows = $this->extractRowsFromTable( $table );
        $headers = $this->extractHeadersFromTable( $table );
        $courtCases = $this->extractRawCaseData( $headers, $rows );
        return $courtCases;
    }

    private function extractRowsFromTable(RemoteWebElement $table) : Collection  {
        $by = WebDriverBy::tagName('tr');
        $rows = collect( $table->findElements($by) );
        $test = $this->getHasRequiredHeaderTextTest();
        $caseRows = $rows->filter( function( RemoteWebElement $aRow ) use ($test ) {
            return $test( $aRow ) === false;
        } );
        return $caseRows;
    }

    private function extractHeadersFromTable(RemoteWebElement $table) : Collection  {
        $by = WebDriverBy::tagName('tr');
        $rows = collect( $table->findElements($by) );
        $test = $this->getHasRequiredHeaderTextTest();
        $headerRows = $rows->filter( function( RemoteWebElement $aRow ) use ($test ) {
            return $test( $aRow ) === true;
        } );
        $headerRow = $headerRows->pop();
        $headerRowCells = collect( $headerRow->findElements( WebDriverBy::tagName('td') ) );
        return $headerRowCells;
    }

    private function extractRawCaseData( Collection $headers, Collection $rows) : Collection {
        $textFormatter = $this->getTextFormatterFunction();
        $headerArray = $headers->map($textFormatter)->all();
        $cases = collect();
        $rows->each( function( RemoteWebElement $aRow ) use ($headerArray, $cases ){
            $by = WebDriverBy::tagName('td');
            $tdCells = collect( $aRow->findElements($by) );
            $case = $this->makeCaseFromTdCells( $tdCells, $headerArray );
            if( $case ){
                $cases->push( $case );
            }
        } );
        return $cases;
    }

    private function getHasRequiredHeaderTextTest() {
        $testMethod = function(RemoteWebElement $table ){
            /* @var $table RemoteWebElement */
            $text = $table->getText();
            $hasDefendantNameHeader = strstr( $text, "Defendant Name" ) !== false;
            $hasCaseNumberHeader = strstr( $text, "Case" ) !== false;
            $hasHearingLocation = strstr( $text, "Hearing" ) !== false;
            return $hasDefendantNameHeader && $hasCaseNumberHeader && $hasHearingLocation;
        };
        return $testMethod;
    }
    
    private function makeCaseFromTdCells( Collection $tdCells, array $headerArray ){
        $textFormatter = $this->getTextFormatterFunction();
        $cellText = $tdCells->map( $textFormatter )->all();
        $keyedData = array_combine($headerArray, $cellText);
        $case = new \App\CourtCase();
        try{
            foreach( $keyedData as $header => $value ){
                $this->setCaseDataByHeader( $case, $header, $value );
            }
            if( trim( $case->number ) == '' || trim( $case->location ) == '' || !is_a($case->datetime, \DateTime::class) ){
                throw new \Exception("Case is missing critical information, which suggests this row of the table is not a case and is formatting only." );
            }
        }catch( \Exception $e ){
            $case = null;
        }
        return $case;
    }

    private function getTextFormatterFunction() {
        $function = function( RemoteWebElement $element ){
            $rawText = $element->getText();
            $noNewLines = str_replace( "\n", " ", $rawText );
            $noDoubleSpaces = str_replace("  ", " ", $noNewLines);
            $formatted = trim( $noDoubleSpaces );
            return $formatted;
        };
        return $function;
    }

    private function setCaseDataByHeader(CourtCase $case, string $header, string $value) {
        switch( $header ){
            case 'Defendant Name':
                $this->setDefendantName( $case, $value );
                break;
            case 'Case Number':
                $this->setCaseNumber( $case, $value );
                break;
            case 'Hearing Date/Time':
                $this->setDateTime( $case, $value );
                break;
            case 'Hearing Location':
                $this->setCourtId( $case, $value );
                break;
            case 'Div/ Dept':
                $this->setDepartmentId( $case, $value );
                break;
            case 'Hearing Type':
                $this->setHearingType( $case, $value );
                break;
        }
    }

    private function setDefendantName(CourtCase $case, string $value) {
        /* @var $case CourtCase */
        $case->name = $value;
    }

    private function setCaseNumber(CourtCase $case, string $value) {
        /* @var $case CourtCase */
        $case->number = $value;
    }

    private function setDateTime(CourtCase $case, string $value) {
        /* @var $case CourtCase */
        $noComma = str_replace(",", "", $value);
        $zone = new \DateTimeZone( "America/Los_Angeles" );
        $date = new Carbon( $noComma, $zone );
        $case->datetime = $date;
    }

    private function setCourtId(CourtCase $case, string $value) {
        /* @var $case CourtCase */
        $case->location = $value; 
    }

    private function setDepartmentId(CourtCase $case, string $value) {
        /* @var $case CourtCase */
        $case->department = $value;
    }

    private function setHearingType(CourtCase $case, string $value) {
        /* @var $case CourtCase */
        $case->hearingType = $value;
    }

}
