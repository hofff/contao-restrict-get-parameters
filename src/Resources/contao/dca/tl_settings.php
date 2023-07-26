<?php

declare(strict_types=1);

use Contao\CoreBundle\DataContainer\PaletteManipulator;

(static function (): void {
    PaletteManipulator::create()
        ->addLegend('restrict_get_parameters_legend', 'chmod_legend')
        ->addField(
            'restrict_get_parameters',
            'restrict_get_parameters_legend',
            PaletteManipulator::POSITION_APPEND,
        )->applyToPalette('default', 'tl_settings');
})();

$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][]             = 'restrict_get_parameters';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['restrict_get_parameters'] = 'restrict_get_parameters_whitelist';

$GLOBALS['TL_DCA']['tl_settings']['fields']['restrict_get_parameters'] = [
    'inputType' => 'checkbox',
    'exclude'   => true,
    'eval'      => [
        'tl_class'       => 'clr',
        'submitOnChange' => true,
    ],
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['restrict_get_parameters_whitelist'] = [
    'inputType' => 'listWizard',
    'exclude'   => true,
    'eval'      => [
        'tl_class'          => 'clr',
        'useRawRequestData' => true,
    ],
];
