<?php

namespace marvin255\serviform\bitrix\ormunique;

use marvin255\serviform\abstracts\Validator as AbstractValidator;

/**
 * Session validator for bitrix
 */
class Validator extends AbstractValidator
{
    /**
     * @var string
     */
    protected $message = 'Field "#label#" is not unique';

    /**
     * @inheritdoc
     */
    protected function vaidateValue($value, $element)
    {
        $orm = $this->getOrm();
        $field = $this->getField();
        $query = [
            'filter' => [
                "=" . $field => $value,
            ],
        ];

        return empty($orm::getRow($query));
    }

    /**
     * @var string
     */
    protected $orm = null;

    /**
     * @var string
     */
    protected $field = null;

    /**
     * @return string
     */
    public function getOrm()
    {
        return $this->orm;
    }

    /**
     * @param string $value
     *
     * @return \marvin255\serviform\bitrix\ormunique\Validator
     */
    public function setOrm($value)
    {
        $this->orm = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $value
     *
     * @return \marvin255\serviform\bitrix\ormunique\Validator
     */
    public function setField($value)
    {
        $this->field = $value;

        return $this;
    }
}
