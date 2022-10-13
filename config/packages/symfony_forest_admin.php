<?php

use ForestAdmin\AgentPHP\DatasourceDoctrine\Datasource;
use Nicolas\SymfonyForestAdmin\Service\ForestAgent;

return static function (ForestAgent $forestAgent) {
    $forestAgent->addDatasource(new Datasource($forestAgent->getEntityManager()))
        ->addDatasource(new ForestAdmin\AgentPHP\DatasourceDummy\DummyDatasource())
        ->customizeCollection('Book', BookCustomize::custom($forestAgent))
    ;
};
