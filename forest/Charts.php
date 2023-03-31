<?php

use App\Entity\Car;
use App\Entity\User;
use ForestAdmin\AgentPHP\DatasourceCustomizer\CollectionCustomizer;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Actions\BaseAction;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Actions\DynamicField;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Actions\Types\FieldType;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Chart\CollectionChartContext;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Chart\ResultBuilder;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Query\Aggregation;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Query\Filters\Filter;
use ForestAdmin\SymfonyForestAdmin\Service\ForestAgent;

if (!function_exists('addCharts')) {
    function addCharts(ForestAgent $forestAgent): ForestAgent
    {
        // add Charts
        $forestAgent->agent
            ->addChart(
                'apiValue',
                fn($context, ResultBuilder $resultBuilder) => $resultBuilder->value(100, 50)
            )
            ->addChart(
                'apiDistribution',
                fn($context, ResultBuilder $resultBuilder) => $resultBuilder->distribution(
                    [
                        'validated'   => 100,
                        'rejected'    => 50,
                        'to_validate' => 30,
                    ]
                )
            )
            ->addChart(
                'apiLeaderboard',
                fn($context, ResultBuilder $resultBuilder) => $resultBuilder->leaderboard(
                    [
                        'Bonanza'   => 5835694,
                        'TalkSpace'    => 4179218,
                        'Tesco' => 3959931,
                        'BitPesa' => 3856685,
                        'Octiv' => 3747458,
                    ]
                )
            )
            ->addChart(
                'apiObjective',
                fn($context, ResultBuilder $resultBuilder) => $resultBuilder->objective(235, 500)
            )
            ->addChart(
                'apiPercentage',
                fn($context, ResultBuilder $resultBuilder) => $resultBuilder->percentage(25.6)
            )
            ->addChart(
                'apiTime',
                fn($context, ResultBuilder $resultBuilder) => $resultBuilder->timeBased(
                    'Month',
                    [
                        '2017-02-01' => 636,
                        '2017-03-01' => 740,
                        '2017-04-01' => 648,
                        '2017-05-01' => 726,
                    ]
                )
            );

        // add Charts on collection
        $forestAgent->agent
            ->customizeCollection('Car',
                fn(CollectionCustomizer $builder) => $builder->addChart(
                    'apiValueCollection',
                    function(CollectionChartContext $context, ResultBuilder $resultBuilder) {
                        $aggregation = new Aggregation('Count', 'id');
                        $data = $context->getCollection()->aggregate(new Filter(), $aggregation);

                        return $resultBuilder->value($data);
                    }
                )
                    ->addChart(
                        'apiDistributionCollection',
                        fn($context, ResultBuilder $resultBuilder) => $resultBuilder->distribution(
                            [
                                'validated'   => 100,
                                'rejected'    => 50,
                                'to_validate' => 30,
                            ]
                        )
                    )
                    ->addChart(
                        'apiLeaderboardCollection',
                        fn($context, ResultBuilder $resultBuilder) => $resultBuilder->leaderboard(
                            [
                                'Bonanza'   => 5835694,
                                'TalkSpace' => 4179218,
                                'Tesco'     => 3959931,
                                'BitPesa'   => 3856685,
                                'Octiv'     => 3747458,
                            ]
                        )
                    )
                    ->addChart(
                        'apiObjectiveCollection',
                        fn($context, ResultBuilder $resultBuilder) => $resultBuilder->objective(235, 500)
                    )
                    ->addChart(
                        'apiPercentageCollection',
                        fn($context, ResultBuilder $resultBuilder) => $resultBuilder->percentage(25.6)
                    )
                    ->addChart(
                        'apiTimeCollection',
                        fn($context, ResultBuilder $resultBuilder) => $resultBuilder->timeBased(
                            'Month',
                            [
                                '2017-02-01' => 636,
                                '2017-03-01' => 740,
                                '2017-04-01' => 648,
                                '2017-05-01' => 726,
                            ]
                        )
                    )
            );

        return $forestAgent;
    }
}
