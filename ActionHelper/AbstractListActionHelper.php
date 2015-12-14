<?php

namespace CuteNinja\ParabolaBundle\ActionHelper;

use Cuteninja\ParabolaBundle\Form\Model\AbstractListFilter;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Exception;

/**
 * Class AbstractListActionHelper
 */
abstract class AbstractListActionHelper
{
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @param AbstractListFilter $filter
     *
     * @return array
     */
    abstract public function buildCriteriaFromFilter(AbstractListFilter $filter);

    /**
     * @param AbstractListFilter $filter
     *
     * @return Query
     */
    abstract public function buildQuery(AbstractListFilter $filter);

    /**
     * @param ObjectRepository $repository
     *
     * @throws Exception
     */
    public function __construct(ObjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param AbstractListFilter $listFilter
     *
     * @return array
     */
    public function buildOrderFromFilter(AbstractListFilter $listFilter)
    {
        $formattedOrders = [];

        if ($listFilter->getOrderBy()) {
            $orders = explode(',', $listFilter->getOrderBy());
            foreach ($orders as $order) {
                if (substr($order, 0, 1) == '-') {
                    $direction = 'DESC';
                    $order     = substr($order, 1);
                } elseif (substr($order, 0, 1) == '+') {
                    $direction = 'ASC';
                    $order     = substr($order, 1);
                } else {
                    $direction = 'ASC';
                }

                $formattedOrders[$order] = $direction;
            }
        }

        return $formattedOrders;
    }
}
