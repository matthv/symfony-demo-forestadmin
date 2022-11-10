<?php

use App\Entity\Product;
use ForestAdmin\AgentPHP\DatasourceCustomizer\CollectionCustomizer;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Computed\ComputedDefinition;
use ForestAdmin\AgentPHP\DatasourceDoctrine\DoctrineDatasource;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Query\ConditionTree\Operators;
use ForestAdmin\SymfonyForestAdmin\Service\ForestAgent;

return static function (ForestAgent $forestAgent) {
    $forestAgent->agent->addDatasource(new DoctrineDatasource($forestAgent->getEntityManager()), ['exclude' => ['DriverLicence'], 'rename' => ['Product' => 'Package']])
        ->addDatasource(new ForestAdmin\AgentPHP\DatasourceDummy\DummyDatasource())
        ->customizeCollection(
            'Book',
            fn (CollectionCustomizer $builder) => $builder->addField(
                'toto',
                new ComputedDefinition(
                    columnType: 'String',
                    dependencies: ["title", "author"],
                    values: fn ($records) => $records,
                )
            )
        )
        ->customizeCollection('Car', function (CollectionCustomizer $builder) {
            $builder->addField(
                'registrationNumber',
                new ComputedDefinition(
                    'String',
                    ['model'],
                    fn ($records) => collect($records)->map(fn ($record) => $record['model'] . ' : BP-' . rand(100, 1000) . '-WY')
                )
            )
                ->replaceFieldSorting('model', null)
                ->replaceFieldSorting(
                    'registrationNumber',
                    [
                      ['field' => 'model', 'ascending' => true]
                    ]
                );
        })
        ->customizeCollection(class_basename(User::class), function (CollectionCustomizer $builder) {
            $builder->replaceSearch(
                fn ($search, $extended) => [
                    'aggregator' => 'And',
                    'conditions' => [
                        ['field' => 'rememberToken', 'operator' => Operators::EQUAL, 'value' => 1],
                        [
                            'aggregator' => 'Or',
                            'conditions' => [
                                ['field' => 'name', 'operator' => Operators::CONTAINS, 'value' => $search],
                                ['field' => 'email', 'operator' => Operators::CONTAINS, 'value' => $search],
                            ],
                        ],
                    ],
                ]
            );
        })
        ->customizeCollection('Package', function (CollectionCustomizer $builder) {
            $builder->addSegment(
                'highPrice',
                fn () => [
                    'field'    => 'price',
                    'operator' => Operators::GREATER_THAN,
                    'value'    => 750,
                ]
            );
        })
        ->build();
};
