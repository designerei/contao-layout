<?php

use Contao\ContentModel;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

$table = ContentModel::getTable();

$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'layoutType';

$GLOBALS['TL_DCA'][$table]['subpalettes']['layoutType_container'] = 'containerSize,containerCenter';
$GLOBALS['TL_DCA'][$table]['subpalettes']['layoutType_grid'] = 'gridTemplateColumns,gridTemplateRows,gap,alignment';
$GLOBALS['TL_DCA'][$table]['subpalettes']['layoutType_flex'] = 'gap,alignment,flexDirection,flexWrap';
$GLOBALS['TL_DCA'][$table]['subpalettes']['layoutType_columns'] = 'columns,gap';

$GLOBALS['TL_DCA'][$table]['palettes']['layout'] = '
    {type_legend},type;
    {layout_legend},layoutType;
    {template_legend:hide},customTpl;
    {protected_legend:hide},protected;
    {expert_legend:hide},cssID;
    {invisible_legend:hide},invisible,start,stop'
;

$GLOBALS['TL_DCA'][$table]['fields']['layoutType'] = [
    'exclude' => true,
    'inputType' => 'select',
    'default' => 'container',
    'eval' => [
        'tl_class' => 'w50 clr',
        'mandatory' => false,
        'submitOnChange' => true,
    ],
    'options' => ['container', 'grid', 'flex', 'columns'],
    'reference' => ['container' => 'Container', 'grid' => 'Grid-Layout', 'flex' => 'Flexbox-Layout', 'columns' => 'Spalten-Layout'],
    'sql' => "varchar(16) NOT NULL default 'container'"
];

$GLOBALS['TL_DCA'][$table]['fields']['containerSize'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'includeBlankOption'=>true,
        'tl_class'=>'w50 clr',
    ],
    'sql' => "varchar(32) NOT NULL default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['containerCenter'] = [
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12'
    ],
    'sql' => "char(1) NOT NULL default ''"
];

$commonUtilityClassField = [
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50 w50h autoheight',
        'multiple' => true,
        'size' => '10',
        'chosen' => true,
        'mandatory' => false
    ],
    'sql' => "text NULL"
];

$utilityClassFields = [
    'alignment',
    'spacing',
    'gap',
    'flexDirection',
    'flexWrap',
    'flex',
    'gridTemplateColumns',
    'gridTemplateRows',
    'gridColumn',
    'gridRow',
    'flexBasis',
    'flex',
    'flexGrow',
    'flexShrink',
    'order',
    'alignmentSelf',
    'columns',
    'break'
];

foreach ($utilityClassFields as $field) {
    $GLOBALS['TL_DCA'][$table]['fields'][$field] = $commonUtilityClassField;
}
