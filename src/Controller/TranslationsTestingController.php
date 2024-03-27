<?php

declare(strict_types=1);

namespace TheRichCourt\TranslationsTestingBundle\Controller;

use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

class TranslationsTestingController extends AbstractController
{
    /** @var string[] */
    private array $locales;

    private TranslatorInterface $translator;

    private RequestStack $requestStack;

    /**
     * @param string[] $locales
     */
    public function __construct(
        array $locales,
        TranslatorInterface $translator,
        RequestStack $requestStack
    ) {
        $this
            ->setLocales($locales)
            ->setTranslator($translator)
            ->setRequestStack($requestStack)
        ;
    }

    public function indexAction(): Response
    {
        if ($this->getRequestStack()->getCurrentRequest() === null) {
            throw new RuntimeException("Cant' get current request");
        }

        $transKey = $this->getRequestStack()->getCurrentRequest()->get('transkey') ?? null;
        $requestedArguments = $this->getRequestStack()->getCurrentRequest()->get('arguments');
        $transArguments = [];

        if (\is_array($requestedArguments)) {
            foreach ($requestedArguments as $requestedArgument) {
                if (!$requestedArgument['key']) {
                    continue;
                }

                $transArguments[$requestedArgument['key']] = $requestedArgument['value'];
            }
        }

        $translations = [];

        if ($transKey) {
            foreach ($this->getLocales() as $locale) {
                $translations[$locale] = $this->getTranslator()->trans($transKey, $transArguments, null, $locale);
            }
        }

        return $this->render('@TranslationsTesting/index.html.twig', [
            'translations' => $translations,
            'trans_key' => $transKey,
            'requested_arguments' => $requestedArguments,
            'trans_arguments' => $transArguments,
        ]);
    }

    /**
     * @return string[]
     */
    private function getLocales(): array
    {
        return $this->locales;
    }

    /**
     * @param string[] $locales
     */
    private function setLocales(array $locales): self
    {
        $this->locales = $locales;

        return $this;
    }

    private function getTranslator(): TranslatorInterface
    {
        return $this->translator;
    }

    private function setTranslator(TranslatorInterface $translator): self
    {
        $this->translator = $translator;

        return $this;
    }

    private function getRequestStack(): RequestStack
    {
        return $this->requestStack;
    }

    private function setRequestStack(RequestStack $requestStack): self
    {
        $this->requestStack = $requestStack;

        return $this;
    }
}
