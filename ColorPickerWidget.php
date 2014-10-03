<?php

namespace cliff363825\colorpicker;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

class ColorPickerWidget extends Widget
{
    /**
     * @var \yii\db\ActiveRecord
     */
    public $model;

    /**
     * @var string
     */
    public $attribute;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $value;

    /**
     * Html Options
     * @var array
     */
    public $options = [];

    /**
     * Widget Options
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var boolean
     */
    public $render = true;

    public function init()
    {
        parent::init();
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
    }

    public function run()
    {
        $this->registerClientScript();
        if ($this->render) {
            if ($this->hasModel()) {
                echo Html::activeTextInput($this->model, $this->attribute, $this->options);
            } else {
                echo Html::textInput($this->name, $this->value, $this->options);
            }
        }
    }

    protected function registerClientScript()
    {
        $view = $this->getView();
        ColorPickerAsset::register($view);
        $options = $this->getClientOptions();
        $options_str = Json::encode($options);
        $js = "
jQuery(function(){
    jQuery('#{$this->options['id']}').colorPicker({$options_str});
});
";
        $view->registerJs($js);
    }

    protected function getClientOptions()
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
        return $options;
    }

    protected function hasModel()
    {
        return $this->model !== null && $this->model instanceof \yii\db\ActiveRecord;
    }
}
