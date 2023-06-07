<?php

declare(strict_types=1);

namespace WPRestClient\Entity;

use WPRestClient\Core\Entity\EntityBase;

/**
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class UserEntity extends EntityBase
{
    protected ?string $description = null;
    protected ?array $avatar_urls = null;
    protected ?array $capabilities = null;
    protected ?string $email = null;
    protected ?array $extra_capabilities = null;
    protected ?string $link = null;
    protected ?string $first_name = null;
    protected ?array $meta = null;
    protected ?string $name = null;
    protected ?string $last_name = null;
    protected ?string $locale = null;
    protected ?string $nickname = null;
    protected ?string $password = null;
    protected ?string $registered_date = null;
    protected ?string $slug = null;
    protected ?array $roles = null;
    protected ?string $url = null;
    protected ?string $username = null;
}
