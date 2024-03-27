<?php

declare(strict_types=1);

namespace Tests\TheRichCourt\TranslationsTestingBundle;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use TheRichCourt\TranslationsTestingBundle\DependencyInjection\Configuration;

/**
 * @internal
 * @covers \TheRichCourt\TranslationsTestingBundle\DependencyInjection\Configuration
 */
final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    public function testValidConfigurationValidates(): void
    {
        $config = [[
            'locales' => [
                'en',
                'fr',
                'es',
            ],
        ]];

        $this->assertConfigurationIsValid($config);
    }

    public function testEmptyLocaleFailsValidation(): void
    {
        $config = [
            'locales' => [], // No locales given at all
        ];

        $this->assertConfigurationIsInvalid($config, 'locales');
    }

    public function testNonScalarLocalesFailValidation(): void
    {
        $config = [
            'locales' => [
                [
                    'en',
                    'es',
                ],
            ],
        ];

        $this->assertConfigurationIsInvalid($config, 'locales');
    }
}
