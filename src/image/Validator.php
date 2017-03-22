<?php

namespace marvin255\serviform\bitrix\image;

use marvin255\serviform\validators\File;

/**
 * Image validator for bitrix
 */
class Validator extends File
{
    /**
     * @param mixed                 $value
     * @param \serviform\IValidator $element
     *
     * @return bool
     */
    protected function vaidateValue($value, $element)
    {
        return !empty($value['del']) ? true : parent::vaidateValue($value, $element);
    }
}
