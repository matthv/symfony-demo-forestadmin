<?php

use ForestAdmin\AgentPHP\Agent\Builder\CollectionBuilder;
use ForestAdmin\AgentPHP\DatasourceDoctrine\DoctrineDatasource;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Query\ConditionTree\Operators;
use ForestAdmin\AgentPHP\DatasourceToolkit\Decorators\Computed\ComputedDefinition;
use ForestAdmin\SymfonyForestAdmin\Service\ForestAgent;

return static function (ForestAgent $forestAgent) {
    $forestAgent->agent->addDatasource(new DoctrineDatasource($forestAgent->getEntityManager()))
        ->addDatasource(new ForestAdmin\AgentPHP\DatasourceDummy\DummyDatasource())
        ->customizeCollection(
            'Book',
            fn (CollectionBuilder $builder) => $builder->addField(
                'toto',
                new ComputedDefinition(
                    columnType: 'String',
                    dependencies: ["title", "author"],
                    values: fn ($records) => $records,
                )
            )
        )
        ->customizeCollection('Car', function (CollectionBuilder $builder) {
            $builder->addField(
                'registrationNumber',
                new ComputedDefinition(
                    'String',
                    ['model'],
                    fn ($records) => collect($records)->map(fn ($record) => $record['model'] . ' : BP-' . rand(100, 1000) . '-WY')
                )
            );
        })
        ->customizeCollection(class_basename(User::class), function (CollectionBuilder $builder) {
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
                        ]
                    ],
                ]
            );
        })
        ->build();
};
