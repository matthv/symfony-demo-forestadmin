<?php

use App\Entity\User;
use ForestAdmin\AgentPHP\DatasourceCustomizer\CollectionCustomizer;
use ForestAdmin\AgentPHP\DatasourceCustomizer\Decorators\Actions\Types\BaseAction;
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
                    );
            });

        return $forestAgent;
    }
}

