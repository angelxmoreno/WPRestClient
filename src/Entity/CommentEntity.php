<?php

declare(strict_types=1);

namespace WPRestClient\Entity;

use WPRestClient\Core\Entity\EntityBase;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class CommentEntity extends EntityBase
{
    protected ?int $author = null;
    protected ?array $author_avatar_urls = null;
    protected ?string $author_email = null;
    protected ?string $author_ip = null;
    protected ?string $author_name = null;
    protected ?string $author_url = null;
    protected ?string $author_user_agent = null;
    protected ?int $post = null;
    protected ?string $type = null;
    protected ?string $content = null;
    protected ?string $date = null;
    protected ?string $date_gmt = null;
    protected ?string $link = null;
    protected ?array $meta = null;
    protected ?int $parent = null;
    protected ?string $status = null;
}
