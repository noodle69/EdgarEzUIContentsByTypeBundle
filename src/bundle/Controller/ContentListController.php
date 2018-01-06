<?php

namespace Edgar\EzUIContentsByTypeBundle\Controller;

use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\Location;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\Core\Pagination\Pagerfanta\ContentSearchAdapter;
use EzSystems\EzPlatformAdminUi\Tab\Dashboard\PagerContentToDataMapper;
use EzSystems\EzPlatformAdminUiBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Edgar\EzUIContentsByType\Form\Data\FilterContentData;
use Edgar\EzUIContentsByType\Form\Factory\FormFactory;
use Edgar\EzUIContentsByType\Form\SubmitHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;

class ContentListController extends Controller
{
    /** @var FormFactory $formFactory */
    protected $formFactory;

    /** @var SearchService $searchService */
    protected $searchService;

    /** @var PagerContentToDataMapper $pagerContentToDataMapper */
    private $pagerContentToDataMapper;

    /** @var SubmitHandler $submitHandler */
    protected $submitHandler;

    public function __construct(
        FormFactory $formFactory,
        SearchService $searchService,
        PagerContentToDataMapper $pagerContentToDataMapper,
        SubmitHandler $submitHandler
    ) {
        $this->formFactory = $formFactory;
        $this->searchService = $searchService;
        $this->pagerContentToDataMapper = $pagerContentToDataMapper;
        $this->submitHandler = $submitHandler;
    }

    public function menuAction(Request $request): Response
    {
        $filterContentType = $this->formFactory->filterContent(
            new FilterContentData()
        );
        $filterContentType->handleRequest($request);
        $filterContentType->getData()->setPage($request->get('page', 1));

        if ($filterContentType->isSubmitted() && $filterContentType->isValid()) {
            $result = $this->submitHandler->handle($filterContentType, function (FilterContentData $data) use ($filterContentType) {
                $limit = $data->getLimit();
                $page = $data->getPage();

                $query = $this->buildQuery($data);
                $pagerfanta = new Pagerfanta(
                    new ContentSearchAdapter($query, $this->searchService)
                );

                $pagerfanta->setMaxPerPage($limit);
                $pagerfanta->setCurrentPage(min($page, $pagerfanta->getNbPages()));

                return $this->render('@EdgarEzUIContentsByType/content/list.html.twig', [
                    'form_filter_content' => $filterContentType->createView(),
                    'results' => $this->pagerContentToDataMapper->map($pagerfanta),
                    'pager' => $pagerfanta,
                ]);
            });

            if ($result instanceof Response) {
                return $result;
            }
        }

        return $this->render('@EdgarEzUIContentsByType/content/list.html.twig', [
            'form_filter_content' => $filterContentType->createView(),
        ]);
    }

    private function buildQuery(FilterContentData $data): Query
    {
        $content_type = $data->getContentType();
        $criterions = [
            new Criterion\ContentTypeIdentifier($content_type->identifier),
        ];

        $onlyVisible = $data->getOnlyVisible();
        if ($onlyVisible) {
            $criterions[] = new Criterion\Visibility(Criterion\Visibility::VISIBLE);
        }

        /** @var Location[] $locations */
        $locations = $data->getLocations();
        if (!empty($locations)) {
            $criterionsLocation = [];
            foreach ($locations as $location) {
                $criterionsLocation[] = new Criterion\ParentLocationId($location->id);
            }
            $queryLocation = new Criterion\LogicalOr($criterionsLocation);
            $criterions[] = $queryLocation;
        }

        $query = new Query();
        $query->filter = new Criterion\LogicalAnd($criterions);
        $query->sortClauses[] = new SortClause\DateModified(Query::SORT_DESC);

        return $query;
    }
}
