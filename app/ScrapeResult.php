<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CourtDateCollection;
use Carbon\Carbon;
use App\CourtCase;

class ScrapeResult extends Model
{
    const FILENAME = 'scraped_collection.dat';
    /** @var Carbon date of last successful scrape */
    private $date;
    
    /** @var CourtDateCollection collection of all data scraped on this date */
    private $dateCollection;
    
    public function initializeEmptyResult(){
        $this->date = new Carbon("now", new \DateTimeZone("America/Los_Angeles"));
        $this->dateCollection = new CourtDateCollection();
    }
    
    public function addCase(CourtCase $case ){
        $this->dateCollection->addCase( $case );
    }
    
    public function store(){
        $path = $this->getStoragePath();
        $serialData = $this->getSerializedData();
        file_put_contents($path, $serialData);
    }
    
    private function getStoragePath(){
        return storage_path(self::FILENAME);
    }

    private function getSerializedData() {
        return \serialize($this);
    }

}
