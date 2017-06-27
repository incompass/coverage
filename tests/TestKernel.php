<?php

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

/**
 * Class TestKernel
 *
 * @author  Joe Mizzi <joe@casechek.com>
 */
class TestKernel extends \Symfony\Component\HttpKernel\Kernel
{
    use MicroKernelTrait;

    /**
     * Returns an array of bundles to register.
     *
     * @return \Symfony\Component\HttpKernel\Bundle\BundleInterface[] An array of bundle instances
     */
    public function registerBundles()
    {
        return [new \Symfony\Bundle\FrameworkBundle\FrameworkBundle()];
    }

    /**
     * Add or import routes into your application.
     *
     *     $routes->import('config/routing.yml');
     *     $routes->add('/admin', 'AppBundle:Admin:dashboard', 'admin_dashboard');
     *
     * @param \Symfony\Component\Routing\RouteCollectionBuilder $routes
     */
    protected function configureRoutes(\Symfony\Component\Routing\RouteCollectionBuilder $routes)
    {

    }

    /**
     * Configures the container.
     *
     * You can register extensions:
     *
     * $c->loadFromExtension('framework', array(
     *     'secret' => '%secret%'
     * ));
     *
     * Or services:
     *
     * $c->register('halloween', 'FooBundle\HalloweenProvider');
     *
     * Or parameters:
     *
     * $c->setParameter('halloween', 'lot of fun');
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $c
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    protected function configureContainer(
        \Symfony\Component\DependencyInjection\ContainerBuilder $c,
        \Symfony\Component\Config\Loader\LoaderInterface $loader
    ) {
        $c->loadFromExtension('framework', [
            'secret' => 'test'
        ]);
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return $this->getRootDir() . '/../var/cache';
    }

    /**
     * @return string
     */
    public function getLogDir()
    {
        return $this->getRootDir() . '/../var/logs';
    }
}
