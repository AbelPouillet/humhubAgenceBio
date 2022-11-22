<?php

namespace humhub\modules\search\interfaces;

interface SearchableMap
{
    public function getResultByDistance($distance, $resultTab);
}

?>
