<?php

namespace Container57IklxC;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getParseFilesService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Pipeline\Stage\Parser\ParseFiles' shared autowired service.
     *
     * @return \phpDocumentor\Pipeline\Stage\Parser\ParseFiles
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Pipeline/Stage/Parser/ParseFiles.php';
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Middleware/Middleware.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/Middleware/ReEncodingMiddleware.php';

        return $container->privates['phpDocumentor\\Pipeline\\Stage\\Parser\\ParseFiles'] = new \phpDocumentor\Pipeline\Stage\Parser\ParseFiles(($container->privates['phpDocumentor\\Parser\\Parser'] ?? $container->load('getParserService')), ($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService')), ($container->privates['phpDocumentor\\Parser\\Middleware\\ReEncodingMiddleware'] ?? ($container->privates['phpDocumentor\\Parser\\Middleware\\ReEncodingMiddleware'] = new \phpDocumentor\Parser\Middleware\ReEncodingMiddleware())));
    }
}
