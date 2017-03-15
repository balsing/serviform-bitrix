<?php

namespace marvin255\serviform\bitrix\session;

use marvin255\serviform\helpers\Html;
use marvin255\serviform\abstracts\Field as AbstractField;

/**
 * Bitrix session field
 */
class Field extends AbstractField
{
    /**
     * @return string
     */
    public function renderInternal()
    {
        $attrubutes = $this->getAttributes();
        $attrubutes['value'] = bitrix_sessid();
        $attrubutes['name'] = $this->getNameChainString();
        $attrubutes['type'] = 'hidden';

        return Html::createTag('input', $attrubutes, false);
    }
}
