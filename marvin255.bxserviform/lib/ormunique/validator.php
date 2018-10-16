<?php

namespace marvin255\bxserviform\ormunique;

use marvin255\serviform\abstracts\Validator as AbstractValidator;

/**
 * Session validator for bitrix.
 */
class Validator extends AbstractValidator
{
    /**
     * @var string
     */
    protected $message = 'Field "#label#" is not unique';
    /**
     * @var bool
     */
    protected $skipOnError = true;
    /**
     * @var bool
     */
    protected $skipOnEmpty = true;

    /**
     * @inheritdoc
     */
    protected function vaidateValue($value, $element)
    {
        $orm = $this->getOrm();
        $field = $this->getField() ? $this->getField() : $element->getName();
        $query = [
            'filter' => [
                '=' . $field => $value,
            ],
        ];
        if ($this->getIgnoreFilter()) {
            $query['filter'] = array_merge($this->getIgnoreFilter(), $query['filter']);
        }

        return empty($orm::getRow($query));
    }

    /**
     * @var string
     */
    protected $orm = null;

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
     * @return \marvin255\bxserviform\ormunique\Validator
     */
    public function setOrm($value)
    {
        $this->orm = $value;

        return $this;
    }

    /**
     * @var string
     */
    protected $field = null;

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
     * @return \marvin255\bxserviform\ormunique\Validator
     */
    public function setField($value)
    {
        $this->field = $value;

        return $this;
    }

    /**
     * @var string
     */
    protected $ignoreFilter = null;

    /**
     * @return array
     */
    public function getIgnoreFilter()
    {
        return $this->ignoreFilter;
    }

    /**
     * @param array $value
     *
     * @return \marvin255\bxserviform\ormunique\Validator
     */
    public function setIgnoreFilter(array $value)
    {
        $this->ignoreFilter = $value;

        return $this;
    }
}
