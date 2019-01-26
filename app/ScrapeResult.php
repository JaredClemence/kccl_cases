<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CourtDateCollection;
use Carbon\Carbon;
use App\CourtCase;

class ScrapeResult extends Model
{
    const FILENAME = 'app/public/scraped_collection.dat';
    /** @var Carbon date of last successful scrape */
    private $date;
    public $hasFile = true;
    
    /** @var CourtDateCollection collection of all data scraped on this date */
    private $dataCollection;
    
    public function __construct() {
        $this->dataCollection = new CourtDateCollection();
    }
    
    public function getCollectedData(){
        return $this->dataCollection;
    }
    
    public function getDate(){
        return $this->date;
    }
    
    public function initializeEmptyResult(){
        $this->date = new Carbon("now", new \DateTimeZone("America/Los_Angeles"));
        $this->dataCollection = new CourtDateCollection();
    }
    
    public function addCase(CourtCase $case ){
        $this->dataCollection->addCase( $case );
    }
    
    public function setHasFile( $bool ){
        $this->hasFile = $bool;
    }
    
    public function store(){
        $path = $this->getStoragePath();
        $serialData = $this->getSerializedData();
        file_put_contents($path, $serialData);
    }
    
    private static function getStoragePath(){
        return storage_path(self::FILENAME);
    }

    private function getSerializedData() {
        return \serialize($this);
    }

    public static function loadCachedFile() {
        $fileContent = self::getCachedFileContent();
        $result = \unserialize($fileContent);
        if( $fileContent === false || $result === false ){
            $result = new ScrapeResult();
            $result->setHasFile( false );
        }else{
            $result->setHasFile( true );
        }
        return $result;
    }

    private static function getCachedFileContent() {
        $path = self::getStoragePath();
        $content = false;
        if( file_exists($path) ){
            $content = file_get_contents($path);
        }
        return $content;
    }

    public function filterByHearingType($search) {
        $collection = $this->dataCollection;
        $this->dataCollection = $collection->filterByHearingType($search);
    }

}
