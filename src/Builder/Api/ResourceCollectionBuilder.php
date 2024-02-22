<?php

declare(strict_types=1);

namespace App\Builder\Api;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Paknahad\Querifier\Filter;
use Symfony\Component\HttpFoundation\Request;

final class ResourceCollectionBuilder
{
    private const DEFAULT_LIMIT = 10;
    private const DEFAULT_PAGE = 1;

    public static function build(QueryBuilder $qb, Request $request): array
    {
        $limit = (int) $request->query->get('limit', self::DEFAULT_LIMIT);
        $page = (int) $request->query->get('page', self::DEFAULT_PAGE);

        $filter = new Filter(PsrRequestBuilder::build($request));
        $collection = $filter->applyFilter($qb)->getQuery()->getResult();

        $pager = new Pagerfanta(new ArrayAdapter($collection));
        $pager
            ->setMaxPerPage($limit)
            ->setCurrentPage($page)
        ;

        return [
            'items' => (array) $pager->getCurrentPageResults(),
            'total' => $pager->getNbResults(),
            'limit' => $pager->getMaxPerPage(),
            'page' => $pager->getCurrentPage(),
            'next' => ($pager->hasNextPage()) ? $pager->getNextPage() : null,
            'prev' => ($pager->hasPreviousPage()) ? $pager->getPreviousPage() : null,
        ];
    }
}
