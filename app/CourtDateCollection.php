<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CaseBasedCollection;
use App\CourtCollection;

class CourtDateCollection extends CaseBasedCollection
{

    protected function getKeyFromCase(CourtCase $case) {
        $date = $case->getDateString();
        return $date;
    }

    protected function getKeyedClassType() {
        return CourtCollection::class;
    }

}
