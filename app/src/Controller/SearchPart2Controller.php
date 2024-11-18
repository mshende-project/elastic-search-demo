<?php

namespace App\Controller;

use Elastica\Query;
use Elastica\Util;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Pagerfanta\Elastica\ElasticaAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class SearchPart2Controller extends AbstractController
{
    public function __construct(private readonly TransformedFinder $finder)
    {

    }

    #[Route(path: '/search/part2', name: 'search_part2')]
    public function search(Request $request, SessionInterface $session)
    {
        try {
            $searchTerm = u($request->query->get('q', ''))->trim();
            $pagination = null;

            if (!$searchTerm->isEmpty()) {
                $elasticaQuery = new Query\MultiMatch();
                $elasticaQuery->setQuery($searchTerm);
                $results = $this->finder->findHybrid($elasticaQuery);
                $totalResults = count($results);

                $adapter = new ElasticaAdapter($this->finder, $elasticaQuery);
                $pagerFanta = new Pagerfanta($adapter);
                $pagerFanta->setCurrentPage($request->query->getInt('page', 1));

                $session->set('searchTerm', $searchTerm);
                $pagination = $pagerFanta;
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return $this->render('search/pagination-search.html.twig', compact('pagination', 'searchTerm'));
    }
}