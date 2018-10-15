<?php

namespace marvin255\bxserviform\honeypot;

use marvin255\serviform\helpers\Html;
use marvin255\serviform\abstracts\Field as AbstractField;
use InvalidArgumentException;

/**
 * Honey pot field for bitrix.
 */
class Field extends AbstractField
{
    /**
     * @return string
     */
    public function renderInternal()
    {
        $return = '';

        $pots = $this->getPots();
        foreach ($pots as $pot) {
            $attributes = array_merge($this->getAttributes(), [
                'type' => 'text',
                'name' => $pot,
                'value' => '',
                'class' => $this->getPotClass(),
            ]);
            $return .= Html::createTag('input', $attributes, false);
        }

        return $return;
    }

    /**
     * @var array
     */
    protected $pots = ['name', 'email'];

    /**
     * @param array $pots
     *
     * @throws \InvalidArgumentException
     */
    public function setPots(array $pots)
    {
        $pots = array_diff(array_map('trim', $pots), ['']);
        if (empty($pots)) {
            throw new InvalidArgumentException("Pots parameter can't be empty");
        }
        $this->pots = $pots;

        return $this;
    }

    /**
     * @return array
     */
    public function getPots()
    {
        return $this->pots;
    }

    /**
     * @var string
     */
    protected $potClass = 'just-another-field';

    /**
     * @param string $class
     *
     * @throws \InvalidArgumentException
     */
    public function setPotClass($class)
    {
        if (trim($class) === '') {
            throw new InvalidArgumentException("potClass parameter can't be empty");
        }
        $this->potClass = $class;

        return $this;
    }

    /**
     * @return array
     */
    public function getPotClass()
    {
        return $this->potClass;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [];
    }
}
