<?php

declare(strict_types=1);

namespace Tests\TheRichCourt\TranslationsTestingBundle;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use TheRichCourt\TranslationsTestingBundle\TranslationsTestingBundle;

/**
 * Since this bundle is a library, we need an application to test it within.
 * Hence this Kernel class
 *
 * @internal
 */
final class TestingKernel extends Kernel
{
    use MicroKernelTrait;

    public function __construct()
    {
        parent::__construct('test', true);
    }

    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new TranslationsTestingBundle(),
        ];
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__ . '/../src/Resources/config/routes/test/routes.yaml', 'test');
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../src/Resources/config/packages/test/*.yaml', 'glob');
    }
}
