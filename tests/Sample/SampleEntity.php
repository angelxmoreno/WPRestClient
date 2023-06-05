<?php

declare(strict_types=1);

namespace WPRestClient\Test\Sample;

use DateTimeInterface;
use WPRestClient\Core\Entity\EntityBase;

class SampleEntity extends EntityBase
{
    protected int $id;
    protected string $name;
    protected int $age;
    public bool $passed;

    public function setAge(DateTimeInterface $date): void
    {
        $this->age = date('Y') - intval($date->format('Y'));
    }

    public function getPassed(): string
    {
        return $this->passed ? 'OK' : 'FAILED';
    }
}
