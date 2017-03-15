<?php

namespace marvin255\serviform\bitrix\session;

use marvin255\serviform\abstracts\Validator as AbstractValidator;

/**
 * Session validator for bitrix
 */
class Validator extends AbstractValidator
{
    /**
     * @inheritdoc
     */
    protected function vaidateValue($value, $element)
    {
        return trim($value) === bitrix_sessid();
    }
}