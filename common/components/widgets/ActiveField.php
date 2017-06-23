<?php

namespace common\components\widgets;

use \kartik\widgets\ColorInput;
use \kartik\slider\Slider;

/**
 * Description of ActiveField
 *
 * @author victor.leite
 */
class ActiveField extends \yii\widgets\ActiveField {

    public function colorPickerInput($options = []) {
	$options = array_merge($this->inputOptions, $options);
	$this->addAriaAttributes($options);
	$this->adjustLabelFor($options);
	$opt = array_merge(['placeholder' => \Yii::t('translation', 'placeholder_select_color')], $options);

	$this->parts['{input}'] = ColorInput::widget([
		    'model' => $this->model,
		    'attribute' => $this->attribute,
		    'options' => $opt
	]);
	return $this;
    }

    public function opacityInput($options = []) {
	$options = array_merge($this->inputOptions, $options);
	$this->addAriaAttributes($options);
	$this->adjustLabelFor($options);

	//$this->model->{$this->attribute} = floatval($this->model->{$this->attribute});

	$this->parts['{input}'] = Slider::widget([
		    'model' => $this->model,
		    'attribute' => $this->attribute,
		    'sliderColor' => Slider::TYPE_PRIMARY,
		    'handleColor' => Slider::TYPE_PRIMARY,
		    'pluginOptions' => $options,
	]);
	return $this;
    }

}
