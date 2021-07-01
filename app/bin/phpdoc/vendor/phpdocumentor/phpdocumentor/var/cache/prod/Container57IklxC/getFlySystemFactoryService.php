<?php

namespace Container57IklxC;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getFlySystemFactoryService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Parser\FlySystemFactory' shared autowired service.
     *
     * @return \phpDocumentor\Parser\FlySystemFactory
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/FileSystemFactory.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/FlySystemFactory.php';
        include_once \dirname(__DIR__, 6).'/league/flysystem/src/FilesystemInterface.php';
        include_once \dirname(__DIR__, 6).'/league/flysystem/src/Plugin/PluggableTrait.php';
        include_once \dirname(__DIR__, 6).'/league/flysystem/src/MountManager.php';

        return $container->privates['phpDocumentor\\Parser\\FlySystemFactory'] = new \phpDocumentor\Parser\FlySystemFactory(new \League\Flysystem\MountManager());
    }
}
