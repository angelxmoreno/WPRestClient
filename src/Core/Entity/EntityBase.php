<?php

declare(strict_types=1);

namespace WPRestClient\Core\Entity;

use Cake\Utility\Hash;

/**
 * @property int|null $id
 */
abstract class EntityBase
{
    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->id = Hash::get($data, 'id');
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
