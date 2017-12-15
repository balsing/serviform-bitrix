<?php

namespace marvin255\serviform\bitrix\captcha;

use marvin255\serviform\helpers\Html;
use marvin255\serviform\abstracts\Field as AbstractField;

/**
 * Captcha field for bitrix.
 */
class Field extends AbstractField
{
    /**
     * @return string
     */
    public function renderInternal()
    {
        $captcha = $this->getCaptcha();
        $sid_name = $this->getNameChainString() . '[sid]';
        $word_name = $this->getNameChainString() . '[word]';

        $return = Html::createTag('input', [
            'type' => 'hidden',
            'name' => $sid_name,
            'value' => $captcha['sid'],
        ], false);

        $return .= Html::createTag('img', [
            'src' => $captcha['src'],
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
    protected $captchaCode = null;

    /**
     * @return array
     */
    protected function getCaptcha()
    {
        if ($this->captchaCode === null) {
            global $APPLICATION;
            $value = $this->getValue();
            $code = empty($value['sid']) ? $APPLICATION->CaptchaGetCode() : $value['sid'];
            $this->captchaCode = [
                'sid' => $code,
                'src' => "/bitrix/tools/captcha.php?captcha_sid={$code}",
            ];
        }

        return $this->captchaCode;
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

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $return = parent::jsonSerialize();
        $return['type'] = 'captcha';
        $return['captcha'] = $this->getCaptcha();

        return $return;
    }
}
