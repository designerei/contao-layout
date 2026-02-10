<?php

namespace designerei\ContaoLayoutBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\StringUtil;

#[AsCallback(table: 'tl_content', target: 'list.sorting.child_record')]
class LayoutTypeLabelListener
{
    public function __invoke(array $row)
    {
        $buffer = (new \tl_content())->addCteType($row);

        if (($row['type'] ?? null) === 'layout') {
            $value = (string) ($row['layoutType'] ?? '');

            if ($value !== '') {
                $reference = $GLOBALS['TL_DCA']['tl_content']['fields']['layoutType']['reference'] ?? [];
                $human = $reference[$value] ?? $value;

                $suffix = ' (' . StringUtil::specialchars((string) $human) . ')';

                if (is_string($buffer)) {
                    $buffer = preg_replace(
                        '~(<div class="cte_type[^"]*">)(.*?)(</div>)~',
                        '$1$2' . $suffix . '$3',
                        $buffer,
                        1
                    );
                } elseif (is_array($buffer) && isset($buffer[0]) && is_string($buffer[0])) {
                    $buffer[0] .= $suffix;
                }
            }
        }

        return $buffer;
    }
}
