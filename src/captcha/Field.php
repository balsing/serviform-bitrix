<?php

namespace marvin255\serviform\bitrix\captcha;

use marvin255\serviform\helpers\Html;
use marvin255\serviform\abstracts\Field as AbstractField;

/**
 * Captcha field for bitrix
 */
class Field extends AbstractField
{
    /**
     * @return string
     */
    public function renderInternal()
    {
        global $APPLICATION;
        $value = $this->getValue();
        if (!empty($value['sid'])) {
            $code = $value['sid'];
        } else {
            $code = $APPLICATION->CaptchaGetCode();
        }
        $sid_name = $this->getNameChainString() . '[sid]';
        $word_name = $this->getNameChainString() . '[word]';

        $return = Html::createTag('input', [
            'type' => 'hidden',
            'name' => $sid_name,
            'value' => $code,
        ], false);

        $return .= Html::createTag('img', [
            'src' => "/bitrix/tools/captcha.php?captcha_sid={$code}",
        ], false);

        $attributes = $this->getAttributes();
        $attributes['name'] = $word_name;
        $attributes['value'] = '';
        $return .= Html::createTag('input', $attributes, false);

        $return = Html::createTag('div', $this->getContainerAttributes(), $return);

        return $return;
    }

    /**
     * @var array
     */
    protected $containerAttributes = [];

    /**
     * @param array $attributes
     */
    public function setContainerAttributes(array $attributes)
    {
        $this->containerAttributes = $attributes;
    }

    /**
     * @return array
     */
    public function getContainerAttributes()
    {
        return $this->containerAttributes;
    }
}
