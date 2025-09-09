<?php

declare(strict_types=1);

namespace Hofff\Contao\RestrictGetParameters\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Hofff\Contao\RestrictGetParameters\HofffContaoRestrictGetParametersBundle;
use Override;

final class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    #[Override]
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(HofffContaoRestrictGetParametersBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
