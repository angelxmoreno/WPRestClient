<?php

declare(strict_types=1);

namespace WPRestClient\Entity;

use WPRestClient\Core\Entity\EntityBase;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class PageEntity extends EntityBase
{
    protected ?int $author = null;
    protected ?string $comment_status = null;
    protected ?string $content = null;
    protected ?string $date = null;
    protected ?string $date_gmt = null;
    protected ?string $excerpt = null;
    protected ?int $featured_media = null;
    protected ?string $generated_slug = null;
    protected ?string $guid = null;
    protected ?string $link = null;
    protected ?int $menu_order = null;
    protected ?array $meta = null;
    protected ?string $modified = null;
    protected ?string $modified_gmt = null;
    protected ?int $parent = null;
    protected ?string $password = null;
    protected ?string $permalink_template = null;
    protected ?string $ping_status = null;
    protected ?string $slug = null;
    protected ?string $status = null;
    protected ?string $template = null;
    protected ?string $title = null;
    protected ?string $type = null;
}
