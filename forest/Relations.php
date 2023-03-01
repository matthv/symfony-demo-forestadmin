<?php

use ForestAdmin\AgentPHP\DatasourceCustomizer\CollectionCustomizer;
use ForestAdmin\SymfonyForestAdmin\Service\ForestAgent;

if (! function_exists('addRelations')) {
    function addRelations(ForestAgent $forestAgent): ForestAgent
    {
        $forestAgent->agent
            ->customizeCollection(
                'Book',
                fn (CollectionCustomizer $builder) => $builder->addManyToOneRelation('user', 'User', 'user_id', 'id')
            )
            ->customizeCollection('Car', function (CollectionCustomizer $builder) {
                $builder->addManyToManyRelation(
                    'myUsers',
                    'User',
                    'car_user',
                    'CarUser',
                    'car_id',
                    'user_id',
                    'id',
                    'id',
                );
            })
            ->customizeCollection('User', function (CollectionCustomizer $builder) {
                $builder
                    ->addOneToManyRelation('books', 'Book', 'user_id')
                    ->addOneToOneRelation('myBook', 'Book', 'user_id')
                    ->addManyToManyRelation(
                        'myCars',
                        'Car',
                        'car_user',
                        'CarUser',
                        'user_id',
                        'car_id',
                        'id',
                        'id',
                    );
            });

        return $forestAgent;
    }
}

