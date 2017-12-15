<?php

namespace marvin255\serviform\bitrix\captcha;

use marvin255\serviform\abstracts\Validator as AbstractValidator;

/**
 * Captcha validator for bitrix.
 */
class Validator extends AbstractValidator
{
    /**
     * @var bool
     */
    protected $skipOnError = false;

    /**
     * @inheritdoc
     */
    protected function vaidateValue($value, $element)
    {
        global $APPLICATION;

        return !empty($value['sid'])
            && !empty($value['word'])
            && $APPLICATION->CaptchaCheckCode($value['word'], $value['sid']);
    }
}
