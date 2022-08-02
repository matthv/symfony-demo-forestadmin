<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Product;
use App\Entity\User;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Charts\LineChart;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Charts\ObjectiveChart;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Charts\PercentageChart;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Charts\PieChart;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Charts\ValueChart;
use Nicolas\SymfonyForestAdmin\Controller\ForestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ForestChartsController extends ForestController
{
    #[Route(self::ROUTE_CHARTS_PREFIX . '/value-chart', name: 'valueChart', methods: ['POST'])]
    public function valueChart()
    {
        $entityManager = $this->doctrine->getManager();
        $totalCars = $entityManager
            ->getRepository(Car::class)
            ->createQueryBuilder('c')
            ->select('count(c)')
            ->getQuery()
            ->getSingleScalarResult();

        return new JsonResponse($this->forestAgent->renderChart(new ValueChart($totalCars)));
    }

    #[Route(self::ROUTE_CHARTS_PREFIX . '/pie-chart', name: 'pieChart', methods: ['POST'])]
    public function pieChart()
    {
        $entityManager = $this->doctrine->getManager();
        $nbCarsPerYear = $entityManager
            ->getRepository(Car::class)
            ->createQueryBuilder('c')
            ->select('c.year AS key, count(c) AS value')
            ->groupBy('c.year')
            ->getQuery()
            ->getResult();


        return new JsonResponse($this->forestAgent->renderChart(new PieChart($nbCarsPerYear)));
    }

    #[Route(self::ROUTE_CHARTS_PREFIX . '/line-chart', name: 'lineChart', methods: ['POST'])]
    public function lineChart()
    {
        $entityManager = $this->doctrine->getManager();
        $avgSeatPerCategory = $entityManager
            ->getRepository(Car::class)
            ->createQueryBuilder('c')
            ->select('cat.label AS label, avg(c.nbSeats) AS values')
            ->join('c.category', 'cat')
            ->groupBy('cat.label')
            ->getQuery()
            ->getResult();


        return new JsonResponse($this->forestAgent->renderChart(new LineChart($avgSeatPerCategory)));
    }

    #[Route(self::ROUTE_CHARTS_PREFIX . '/percentage-chart', name: 'percentageChart', methods: ['POST'])]
    public function percentageChart()
    {
        $entityManager = $this->doctrine->getManager();
        $totalCustomers = $entityManager
                ->getRepository(User::class)
                ->createQueryBuilder('u')
                ->select('count(u)')
                ->getQuery()
                ->getSingleScalarResult();


        return new JsonResponse($this->forestAgent->renderChart(new PercentageChart($totalCustomers)));
    }

    #[Route(self::ROUTE_CHARTS_PREFIX . '/objective-chart', name: 'objectiveChart', methods: ['POST'])]
    public function objectiveChart()
    {
        $entityManager = $this->doctrine->getManager();
        $priceMax = $entityManager
            ->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->select('MAX(p.price) as value')
            ->getQuery()
            ->getSingleScalarResult();

        $objective = 1000;

        return new JsonResponse($this->forestAgent->renderChart(new ObjectiveChart($priceMax, $objective)));
    }
}
