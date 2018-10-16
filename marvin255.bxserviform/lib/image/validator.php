<?php

namespace marvin255\bxserviform\image;

use marvin255\serviform\validators\File;

/**
 * Image validator for bitrix.
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
        return !empty($value['del']) || (empty($value['tmp_name']) && array_key_exists('description', $value))
            ? true
            : parent::vaidateValue($value, $element);
    }
}
