<?php

namespace App\Controller;

use Elastica\Query;
use Elastica\Util;
use FOS\ElasticaBundle\Finder\TransformedFinder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class SearchController extends AbstractController
{
    public function __construct(private readonly TransformedFinder $finder)
    {

    }

    #[Route(path: '/search', name: 'search')]
    public function search(Request $request, SessionInterface $session)
    {
        try {
            $searchTerm = u($request->query->get('q', ''))->trim();
            if (!$searchTerm->isEmpty()) {
                $elasticaQuery = new Query\MultiMatch();
                $elasticaQuery->setQuery($searchTerm);
                $results = $this->finder->findHybrid(Util::escapeTerm($searchTerm));
                $session->set('searchTerm', $searchTerm);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return $this->render('search/search.html.twig', compact('results', 'searchTerm'));
    }
}