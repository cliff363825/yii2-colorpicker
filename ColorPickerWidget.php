<?php

namespace cliff363825\colorpicker;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class ColorPickerWidget extends InputWidget
{
    /**
     * Widget Options
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var boolean
     */
    public $render = true;

    public function run()
    {
        if ($this->render) {
            if ($this->hasModel()) {
                echo Html::activeTextInput($this->model, $this->attribute, $this->options);
            } else {
                echo Html::textInput($this->name, $this->value, $this->options);
            }
        }
        $this->registerClientScript();
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        $this->initClientOptions();
        $id = $this->options['id'];
        $js = "
jQuery(function(){
    jQuery('#{$id}').colorPicker(" . Json::encode($this->clientOptions) . ");
});
";
        ColorPickerAsset::register($view);
        $view->registerJs($js);
    }

    protected function initClientOptions()
    {
        // ColorPicker optional params
        $params = [
            'pickerDefault',
            'colors',
            'transparency',
            'onColorChange',
        ];
        $onColorChange = '
function(id, newValue) {
    console.log("ID: " + id + " has been changed to " + newValue);
}
';
        $options = [];
        $options['onColorChange'] = new JsExpression($onColorChange);
        foreach ($params as $key) {
            if (isset($this->clientOptions[$key])) {
                $options[$key] = $this->clientOptions[$key];
            }
        }
        $this->clientOptions = $options;
    }
}
