<?php

namespace designerei\ContaoLayoutBundle\EventListener\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;

#[AsCallback(table: 'tl_content', target: 'config.onpalette')]
class ContentPaletteCallback
{
    public function __invoke(string $palette, DataContainer $dc): string
    {
        $currentRecord = $dc->getCurrentRecord();

        if (null === $currentRecord) {
            return $palette;
        }

        $pid = $currentRecord['pid'] ?? null;
        if (!$pid) {
            return $palette;
        }

        $parentRecord = $dc->getCurrentRecord($pid);

        if ($parentRecord && (($parentRecord['type'] ?? null) === 'layout')) {
            $layoutType = $parentRecord['layoutType'];

            if ($layoutType == 'grid') {
                $palette = PaletteManipulator::create()
                    ->addLegend('layout_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
                    ->addField(['gridColumn', 'gridRow', 'order', 'alignmentSelf'], 'layout_legend', PaletteManipulator::POSITION_APPEND)
                    ->applyToString($palette)
                ;
            }
            elseif ($layoutType == 'flex')
            {
                $palette = PaletteManipulator::create()
                    ->addLegend('layout_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
                    ->addField(['flexBasis', 'flex', 'flexGrow', 'flexShrink', 'order', 'alignmentSelf'], 'layout_legend', PaletteManipulator::POSITION_APPEND)
                    ->applyToString($palette)
                ;
            }
            elseif ($layoutType == 'columns')
            {
                $palette = PaletteManipulator::create()
                    ->addLegend('layout_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
                    ->addField(['break'], 'layout_legend', PaletteManipulator::POSITION_APPEND)
                    ->applyToString($palette)
                ;
            }
        }

        $palette = PaletteManipulator::create()
            ->addLegend('style_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
            ->addField('spacing', 'style_legend', PaletteManipulator::POSITION_APPEND)
            ->applyToString($palette)
        ;

        return $palette;
    }
}