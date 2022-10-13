<?php

use ForestAdmin\AgentPHP\DatasourceDoctrine\DoctrineDatasource;
use Nicolas\SymfonyForestAdmin\Service\ForestAgent;

return static function (ForestAgent $forestAgent) {
    $forestAgent->addDatasource(new DoctrineDatasource($forestAgent->getEntityManager()))
        ->addDatasource(new ForestAdmin\AgentPHP\DatasourceDummy\DummyDatasource());
};
