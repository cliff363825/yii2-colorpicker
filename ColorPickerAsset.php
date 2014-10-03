<?php

namespace cliff363825\colorpicker;

use yii\web\AssetBundle;

class ColorPickerAsset extends AssetBundle
{
    public $sourcePath = '@cliff363825/colorpicker/assets';
    public $js = [
        'jquery.colorPicker.js',
    ];
    public $css = [
        'colorPicker.css',
    ];

}
