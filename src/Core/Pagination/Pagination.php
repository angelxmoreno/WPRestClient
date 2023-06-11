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


}