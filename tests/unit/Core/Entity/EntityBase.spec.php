<?php

declare(strict_types=1);

use Kahlan\Plugin\Double;
use WPRestClient\Core\Entity\EntityBase;

describe(EntityBase::class, function () {
    it('sets data via its constructor', function () {
        $data = [
            'id' => 123,
        ];
        $SampleEntityClass = Double::classname([
            'class' => 'WPRestClient\Entity\SampleEntity',
            'extends' => EntityBase::class
        ]);
        $sampleEntity = new $SampleEntityClass($data);
        expect($sampleEntity->getId())->toBe($data['id']);
    });
});
