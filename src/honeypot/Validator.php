<?php

namespace marvin255\serviform\bitrix\honeypot;

use marvin255\serviform\abstracts\Validator as AbstractValidator;

/**
 * Honey pot validator for bitrix.
 */
class Validator extends AbstractValidator
{
    /**
     * @var string
     */
    protected $message = 'It\'s a bot!';

    /**
     * @param mixed                                 $value
     * @param \marvin255\serviform\interfaces\Field $element
     *
     * @return bool
     */
    protected function vaidateValue($value, $element)
    {
        $return = true;
        $pots = $element->getPots();
        foreach ($pots as $pot) {
            if (isset($_REQUEST[$pot]) && $_REQUEST[$pot] === '') {
                continue;
            }
            $return = false;
            break;
        }

        return $return;
    }
}
