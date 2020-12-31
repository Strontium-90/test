<?php

use App\Controller\TaskController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\Setup;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__.'/templates');
$twig = new Environment($loader, [
    'cache' => __DIR__.'/var/compilation_cache',
]);
$isDevMode = true;
$config = Setup::createYAMLMetadataConfiguration(
    [
        __DIR__."/config/doctrine"
    ],
    $isDevMode,
    __DIR__.'/var/proxy'
);
$namespaces = array(
    __DIR__."/config/doctrine" => 'App\Model'
);
$driver = new SimplifiedYamlDriver($namespaces);
$config->setMetadataDriverImpl($driver);
$conn = array(
    'url' => 'postgresql://postgres:postgres@test-postgresql:5432/test?serverVersion=12&charset=utf8',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

$controllers = [
    'task' => new TaskController($twig, $entityManager)
];

$routes = [
    'tasks' => [
        'controller' => 'task',
        'method' => 'list',
    ],
];
