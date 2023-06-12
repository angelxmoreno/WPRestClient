<?php

declare(strict_types=1);

namespace WPRestClient\Core\Pagination;

use WPRestClient\Core\Entity\EntityBase;

class PaginatedResult
{
    /**
     * @var EntityBase[]
     */
    protected array $items = [];
    protected Pagination $pagination;

    /**
     * @param EntityBase[] $items
     */
    public function __construct(array $items, int $page, int $limit, int $totalItems)
    {
        $this->items = $items;
        $this->pagination = new Pagination($page, $limit, $totalItems);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }
}
