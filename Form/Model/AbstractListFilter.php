<?php

namespace CuteNinja\ParabolaBundle\Form\Model;

/**
 * Class AbstractListFilter
 */
abstract class AbstractListFilter
{
    const CONTEXT_COMMON = 'common';
    const CONTEXT_GET    = 'get';
    const CONTEXT_LIST   = 'list';

    const DEFAULT_PAGE          = 1;
    const DEFAULT_ITEM_PER_PAGE = 1000;

    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $itemPerPage;

    /**
     * @var array
     */
    protected $context;

    /**
     * @var string
     */
    private $orderBy;

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page ?: static::DEFAULT_PAGE;
    }

    /**
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return int
     */
    public function getItemPerPage()
    {
        return $this->itemPerPage ?: static::DEFAULT_ITEM_PER_PAGE;
    }

    /**
     * @param int $itemPerPage
     */
    public function setItemPerPage($itemPerPage)
    {
        $this->itemPerPage = $itemPerPage;
    }

    /**
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param array $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return string
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param string $orderBy
     */
    public function setOrderBy($orderBy)
    {
        $this->orderBy = $orderBy;
    }
}
