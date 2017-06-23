<?php

namespace common\components\widgets\config;

use \common\components\widgets\ActiveField;
use \common\models\Config;

/**
 * Description of ConfigActiveField
 *
 * @author victor.leite
 */
class ConfigActiveField extends ActiveField {

    public function specificField($varname, $options = []) {
	switch ($varname) {
	    case Config::VARNAME_MAP_DEFULT_ZOOM:
		return $this->opacityInput([
			'orientation' => 'horizontal',
			'min' => 0,
			'max' => 19,
			'step' => 0.1,
			'reversed' => false,
			'tooltip' => 'always'
		    ]);
	    case Config::VARNAME_JURISDICTION_DEFAULT_LAYER_COLOR:
		return $this->colorPickerInput($options);
	    case Config::VARNAME_JURISDICTION_DEFAULT_LAYER_OPACITY:
		return $this->opacityInput([
			'orientation' => 'horizontal',
			'min' => 0,
			'max' => 1,
			'step' => 0.1,
			'reversed' => false,
			'tooltip' => 'always'
		    ]);

	    default:
		return $this->textInput($options);
	}
    }

}
