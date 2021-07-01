<?php

namespace Container57IklxC;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getProjectDescriptorBuilderService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Descriptor\ProjectDescriptorBuilder' shared autowired service.
     *
     * @return \phpDocumentor\Descriptor\ProjectDescriptorBuilder
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Descriptor/ProjectDescriptorBuilder.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Descriptor/Builder/AssemblerFactory.php';
        include_once \dirname(__DIR__, 5).'/reflection-docblock/src/DocBlock/ExampleFinder.php';

        return $container->privates['phpDocumentor\\Descriptor\\ProjectDescriptorBuilder'] = new \phpDocumentor\Descriptor\ProjectDescriptorBuilder(\phpDocumentor\Descriptor\Builder\AssemblerFactory::createDefault(($container->privates['phpDocumentor\\Reflection\\DocBlock\\ExampleFinder'] ?? ($container->privates['phpDocumentor\\Reflection\\DocBlock\\ExampleFinder'] = new \phpDocumentor\Reflection\DocBlock\ExampleFinder()))), ($container->privates['phpDocumentor\\Descriptor\\Filter\\Filter'] ?? $container->load('getFilterService')), new RewindableGenerator(function () use ($container) {
            yield 0 => ($container->privates['phpDocumentor\\Transformer\\Writer\\Graph'] ?? $container->load('getGraphService'));
            yield 1 => ($container->privates['phpDocumentor\\Transformer\\Writer\\RenderGuide'] ?? $container->load('getRenderGuideService'));
        }, 2));
    }
}
