<?php

declare(strict_types=1);

namespace WPRestClient\Entity;

use Cake\Utility\Hash;
use WPRestClient\Core\Entity\EntityBase;

class PostEntity extends EntityBase
{
    protected string $title;

    public function setTitle($title): void
    {
        $this->title = is_string($title)
            ? $title
            : Hash::get($title, 'rendered', null);
    }
}
