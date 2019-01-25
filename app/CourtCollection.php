<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CaseBasedCollection;
use App\CaseCollection;

class CourtCollection extends CaseBasedCollection
{
    protected function getKeyFromCase(CourtCase $case) {
        $courtName = $case->getCourtName();
        return $courtName;
    }

    protected function getKeyedClassType() {
        return CaseCollection::class;
    }

}
