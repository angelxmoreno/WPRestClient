<?php

declare(strict_types=1);

namespace WPRestClient\Entity;

use WPRestClient\Core\Entity\EntityBase;

class TagEntity extends EntityBase
{
    protected ?int $count = null;
    protected ?string $description = null;
    protected ?string $link = null;
    protected ?array $meta = null;
    protected ?string $name = null;
    protected ?string $slug = null;
    protected ?string $taxonomy = null;
}
