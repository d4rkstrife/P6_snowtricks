<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;




class Paginator
{
    private RequestStack $requestStack;
    private int $page;
    private int $itemsPerPage;
    private int $maxItems;

    public function __construct(RequestStack $requestStack, ParameterBagInterface $params)
    {
        $this->requestStack = $requestStack;
        $this->page = $this->getPage();
        $this->itemsPerPage = $params->get('app.itemperpage');
    }

    public function numberOfItems(): int
    {
        return $this->page * $this->itemsPerPage;
    }

    public function getPage(): int
    {
        $request = $this->requestStack->getCurrentRequest()->get('page');
        if ($request) {
            return $request;
        } elseif (!$request) {
            return 1;
        }
    }
    public function numberOfPages(int $nbrItems): int
    {
        return ceil($nbrItems / $this->itemsPerPage);
    }
}
