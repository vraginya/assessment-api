<?php

namespace App\DataDestination;

interface DataDestinationInterface
{
    public function persist($data);
}
