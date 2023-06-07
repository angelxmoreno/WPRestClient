<?php

declare(strict_types=1);

namespace WPRestClient\Entity;

use WPRestClient\Core\Entity\EntityBase;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class MediaEntity extends EntityBase
{
    protected ?string $alt_text = null;
    protected ?int $author = null;
    protected ?string $caption = null;
    protected ?string $comment_status = null;
    protected ?string $date = null;
    protected ?string $date_gmt = null;
    protected ?string $description = null;
    protected ?string $generated_slug = null;
    protected ?string $guid = null;
    protected ?string $link = null;
    protected ?array $media_details = null;
    protected ?string $media_type = null;
    protected ?array $meta = null;
    protected ?string $mime_type = null;
    protected ?array $missing_image_sizes = null;
    protected ?string $modified = null;
    protected ?string $modified_gmt = null;
    protected ?string $permalink_template = null;
    protected ?string $ping_status = null;
    protected ?int $post = null;
    protected ?string $slug = null;
    protected ?string $source_url = null;
    protected ?string $status = null;
    protected ?string $template = null;
    protected ?string $title = null;
    protected ?string $type = null;
}
