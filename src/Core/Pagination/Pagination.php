<?php
declare(strict_types=1);

namespace WPRestClient\Core\Pagination;

class Pagination
{
    protected int $page;
    protected int $limit;
    protected int $total_items;
    protected int $total_pages;

    /**
     * @param int $page
     * @param int $limit
     * @param int $totalItems
     */
    public function __construct(int $page, int $limit, int $totalItems)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->total_items = $totalItems;
        $this->total_pages = (int)ceil($totalItems / $limit);
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getTotalItems(): int
    {
        return $this->total_items;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->total_pages;
    }

    public function hasPrevious(): bool
    {
        return $this->getPage() > 1;
    }

    public function hasNext(): bool
    {
        return $this->getPage() < $this->getTotalPages();
    }

    public function previousPage(): int
    {
        return $this->hasPrevious()
            ? $this->getPage() - 1
            : 1;
    }

    public function nextPage(): int
    {
        return $this->hasNext()
            ? $this->getPage() + 1
            : 1;
    }
}
