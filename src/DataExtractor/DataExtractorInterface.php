<?php

namespace App\DataExtractor;

interface DataExtractorInterface
{
    public function extract(array $data, $primaryKey);
}
