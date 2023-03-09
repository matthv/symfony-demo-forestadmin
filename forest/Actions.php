<?php

use App\Entity\User;
use ForestAdmin\AgentPHP\DatasourceCustomizer\CollectionCustomizer;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Actions\BaseAction;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Actions\DynamicField;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Actions\Types\FieldType;
use ForestAdmin\SymfonyForestAdmin\Service\ForestAgent;

if (! function_exists('addActions')) {
    function addActions(ForestAgent $forestAgent): ForestAgent
    {
        $forestAgent->agent
            ->customizeCollection(class_basename(User::class), function (CollectionCustomizer $builder) {
                $builder
                    ->addAction(
                        'Mark as live',
                        new BaseAction(
                            'SINGLE',
                            fn($context, $responseBuilder) => $responseBuilder->success('BRAVO !!!!')
                        )
                    )
                    ->addAction(
                        'Action error',
                        new BaseAction(
                            'SINGLE',
                            fn($context, $responseBuilder) => $responseBuilder->error(
                                'error',
                                ['html' => '<div><p class="c-clr-1-4 l-mb">HA HA t\'es nul !!!</p><img src="https://media0.giphy.com/media/cO39srN2EUIRaVqaVq/giphy.gif?cid=6c09b952gd8u1a1c623uprp1b3dxsninc64eaxpbmy4c5stl&rid=giphy.gif&ct=g"></div>']
                            )
                        )
                    )
                    ->addAction(
                        'Action file',
                        new BaseAction(
                            'SINGLE',
                            fn($context, $responseBuilder) => $responseBuilder->file(file_get_contents('../test.txt'), 'filedemo', 'text/plain')
                        )
                    )
                    ->addAction(
                        'Html response',
                        new BaseAction(
                            'SINGLE',
                            fn ($context, $responseBuilder) => $responseBuilder->success(
                                'ok',
                                ['html' => '<strong class="c-form__label--read c-clr-1-2">SECRET IDENTITY</strong><p class="c-clr-1-4 l-mb">I\'m Batman</p>'])
                        )
                    )
                    ->addAction(
                        'Webhook response',
                        new BaseAction(
                            'SINGLE',
                            fn ($context, $responseBuilder) => $responseBuilder->webhook(
                                'https://www.google.fr',
                                'GET',
                            )

                        )
                    )
                    ->addAction(
                        'Redirect response',
                        new BaseAction(
                            'SINGLE',
                            fn ($context, $responseBuilder) => $responseBuilder->redirectTo('https://www.google.com/maps/place/Le+Bois+Bernard,+36350+Luant/@46.7417455,1.5475855,17z')
                        )
                    )
                    ->addAction(
                        'Basic form',
                        new BaseAction(
                            scope: 'SINGLE',
                            execute: fn($context, $responseBuilder) => $responseBuilder->success('BRAVO !!!!'),
                            form: [
                                new DynamicField(type: FieldType::NUMBER, label: 'amount'),
                                new DynamicField(type: FieldType::STRING, label: 'description', isRequired: true),
                                new DynamicField(
                                    type: FieldType::STRING,
                                    label: 'salveta',
                                    description: 'elle a mis le sud en bouteille pas le sel!',
                                    isReadOnly: true,
                                    value: 'elle a mis le sud en bouteille pas le sel!'
                                )
                            ]
                        )
                    )
                    ->addAction(
                        'Load form',
                        new BaseAction(
                            scope: 'SINGLE',
                            execute: fn($context, $responseBuilder) => $responseBuilder->success('BRAVO !!!!'),
                            form: [
                                new DynamicField(type: FieldType::NUMBER, label: 'amount'),
                                new DynamicField(type: FieldType::STRING, label: 'description', isRequired: true),
                                new DynamicField(
                                    type: FieldType::STRING,
                                    label: 'salveta',
                                    description: 'elle a mis le sud en bouteille pas le sel!',
                                    isReadOnly: true,
                                    value: fn() => 'ok'
                                )
                            ]
                        )
                    )
                    ->addAction(
                        'Change form',
                        new BaseAction(
                            scope: 'SINGLE',
                            execute: fn($context, $responseBuilder) => $responseBuilder->success('BRAVO !!!!'),
                            form: [
                                new DynamicField(type: FieldType::NUMBER, label: 'amount'),
                                new DynamicField(type: FieldType::STRING, label: 'description', isRequired: true),
                                new DynamicField(
                                    type: FieldType::STRING,
                                    label: 'amount X10',
                                    isReadOnly: true,
                                    value: function ($context) {
                                        return $context->getFormValue('amount') * 10;
                                    }
                                )
                            ]
                        )
                    )
                    ->addAction(
                        'Leave a review',
                        new BaseAction(
                            scope: 'SINGLE',
                            execute: fn($context, $responseBuilder) => $responseBuilder->success('Thank you for your review!'),
                            form: [
                                new DynamicField(type: FieldType::ENUM, label: 'Rating', enumValues: [1,2,3,4,5]),
                                new DynamicField(
                                    type: FieldType::STRING,
                                    label: 'Put a comment',
                                    if: fn ($context) => $context->getFormValue('Rating') !== null && $context->getFormValue('Rating') < 4
                                )
                            ],
                        )
                    );
            });

        return $forestAgent;
    }
}
