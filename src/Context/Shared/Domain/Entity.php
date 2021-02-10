<?php

declare(strict_types=1);

namespace App\Context\Shared\Domain;


interface Entity
{
    public function id(): Id;
}