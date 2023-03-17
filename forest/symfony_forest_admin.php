<?php

require 'Actions.php';
require 'Relations.php';

use ForestAdmin\AgentPHP\Agent\Utils\Env;
use ForestAdmin\AgentPHP\DatasourceCustomizer\CollectionCustomizer;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Computed\ComputedDefinition;
use ForestAdmin\AgentPHP\DatasourceDoctrine\DoctrineDatasource;
use ForestAdmin\AgentPHP\DatasourceToolkit\Components\Query\ConditionTree\Operators;
use ForestAdmin\SymfonyForestAdmin\Service\ForestAgent;

return static function (ForestAgent $forestAgent) {

//    $logger = new Logger('forest-log');
//    $logger->pushHandler(new StreamHandler(__DIR__ . '/../../var/log/forest.log'));

    $forestAgent->agent->addDatasource(
        new DoctrineDatasource($forestAgent->getEntityManager(), [
                // solution 1
                'url'      => Env::get('DATABASE_URL'),
                // solution 2
                //                'driver'   => Env::get('DATABASE_DRIVER'),
                //                'host'     => Env::get('DATABASE_HOST'),
                //                'port'     => Env::get('DATABASE_PORT'),
                //                'database' => Env::get('DATABASE_NAME'),
                //                'username' => Env::get('DATABASE_USERNAME'),
                //                'password' => Env::get('DATABASE_PASSWORD'),
            ]),
        [
            //'include' => ['DriverLicence', 'Car', 'User', 'Product'],
            'rename' => ['Product' => 'Package'],
        ]
    )
       //->setLogger($logger)
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
                        ['field' => 'model', 'ascending' => true],
                    ]
                )
//                ->addFieldValidation('nb_seats', Operators::PRESENT)
//                ->addFieldValidation('nb_seats', Operators::PRESENT)
//                ->addFieldValidation('nb_seats', Operators::GREATER_THAN, 4)
                ->addFieldValidation('nb_seats', Operators::IN, [4,5,6])
                ->disableCount();
        })
        ->customizeCollection(class_basename(User::class), function (CollectionCustomizer $builder) {
            $builder->replaceSearch(
                fn ($search, $extended) => [
                    'aggregator' => 'And',
                    'conditions' => [
                        ['field' => 'remember_token', 'operator' => Operators::EQUAL, 'value' => 1],
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
        });

    $forestAgent = addActions($forestAgent);
    $forestAgent = addRelations($forestAgent);

    $forestAgent->agent->build();

//        ->customizeCollection('Package', function (CollectionCustomizer $builder) {
//            $builder->addSegment(
//                'highPrice',
//                fn () => [
//                    'field'    => 'price',
//                    'operator' => Operators::GREATER_THAN,
//                    'value'    => 750,
//                ]
//            )
//                ->replaceFieldOperator('name',
//                    Operators::EQUAL,
////                    fn ($value) => [
////                        'field'    => 'name',
////                        'operator' => Operators::IN,
////                        'value'    => $value,
////                    ]
//                );
//        })

};

