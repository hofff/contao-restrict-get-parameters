<?php

declare(strict_types=1);

namespace Hofff\Contao\RestrictGetParameters\EventListener;

use Contao\Config;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\Input;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\RequestStack;

use function array_keys;
use function array_map;
use function array_unique;
use function implode;
use function preg_match;
use function sprintf;
use function str_replace;

#[AsHook('initializeSystem')]
final class UnusedGetParameterListener
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ScopeMatcher $scopeMatcher,
        private readonly ContaoFramework $framework,
    ) {
    }

    /** @SuppressWarnings(PHPMD.Superglobals) */
    public function __invoke(): void
    {
        if (! $this->framework->createInstance(Config::class)->get('restrict_get_parameters')) {
            return;
        }

        $request = $this->requestStack->getCurrentRequest();
        if ($request === null || ! $this->scopeMatcher->isFrontendRequest($request)) {
            return;
        }

        foreach (array_keys($_GET) as $key) {
            if ($this->isKeyWhitelisted((string) $key)) {
                continue;
            }

            Input::setUnusedGet((string) $key, Input::get((string) $key));
        }
    }

    private function isKeyWhitelisted(string $key): bool
    {
        /** @var string|null $pattern */
        static $pattern = null;
        if ($pattern === null) {
            $pattern = $this->compilePattern();
        }

        return (bool) preg_match($pattern, $key);
    }

    private function compilePattern(): string
    {
        $pattern = array_map(
            static function (string $parameter): string {
                return str_replace(['*', '#'], ['.*', '\\#'], $parameter);
            },
            array_unique(
                (array) StringUtil::deserialize(
                    $this->framework->createInstance(Config::class)->get('restrict_get_parameters_whitelist'),
                    true,
                ),
            ),
        );

        return sprintf('#%s#i', implode('|', $pattern));
    }
}