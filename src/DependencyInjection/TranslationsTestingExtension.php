<?php

declare(strict_types=1);

namespace TheRichCourt\TranslationsTestingBundle\DependencyInjection;

use RuntimeException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use TheRichCourt\TranslationsTestingBundle\Controller\TranslationsTestingController;

class TranslationsTestingExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @param mixed[] $configs
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);

        if (!$configuration) {
            throw new RuntimeException("Configuration shouldn't be null - is your project set up correctly?");
        }

        $config = $this->processConfiguration($configuration, $configs);

        if (!$config['locales']) {
            throw new RuntimeException('Please set an array of locales for the TranslationsTestingBundle');
        }

        $translationsTestingControllerDefinition = (new Definition(TranslationsTestingController::class))
            ->setBindings([
                '$locales' => $config['locales'],
            ])
            ->setAutoconfigured(true)
            ->setAutowired(true)
        ;

        $container->setDefinition(
            $translationsTestingControllerDefinition->getClass() ?? '',
            $translationsTestingControllerDefinition
        );
    }
}
