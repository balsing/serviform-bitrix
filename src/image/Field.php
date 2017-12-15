<?php

namespace marvin255\serviform\bitrix\image;

use marvin255\serviform\helpers\Html;
use marvin255\serviform\fields\File;
use CFile;

/**
 * Bitrix file field.
 */
class Field extends File
{
    /**
     * @return string
     */
    public function renderInternal()
    {
        $render = '';
        $file = $this->getDataBaseFileInfo();
        if ($file) {
            $render .= Html::createTag('img', ['src' => $file['SRC']], false);
            $render .= '<label>';
            $render .= Html::createTag(
                'input',
                [
                    'type' => 'checkbox',
                    'name' => $this->getNameChainString() . '[del]',
                    'value' => 'Y',
                ],
                false
            );
            $render .= ' ' . $this->getRemoveLabel() . '</label>';
        }
        $attributes = $this->getAttributes();
        $attributes['type'] = 'file';
        $attributes['value'] = $this->getValue();
        $attributes['name'] = $this->getNameChainString();
        $render .= Html::createTag('input', $attributes, false);

        if ($description = $this->getDescription()) {
            $attributesDescription = $this->getAttributes();
            $attributesDescription['value'] = isset($file['DESCRIPTION']) ? $file['DESCRIPTION'] : '';
            $attributesDescription['type'] = isset($description['type']) ? $description['type'] : 'text';
            $attributesDescription['name'] = isset($description['name']) ? $description['name'] : $this->getNameChainString() . '[description]';
            $attributesDescription['placeholder'] = isset($description['placeholder']) ? $description['placeholder'] : '';
            $render .= Html::createTag('input', $attributesDescription, false);
        }

        return Html::createTag('div', $this->getContainerAttributes(), $render);
    }

    /**
     * @inheritdoc
     */
    public function setValue($value)
    {
        if (is_numeric($value)) {
            $this->setImage($value);
            $value = [];
        }
        parent::setValue($value);
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        $return = null;
        $values = parent::getValue();
        $parentValue = $this->value;

        if (!empty($values) && $values['error'] != 4) {
            $return = $values;
            $return['description'] = isset($parentValue['description'])
                ? $parentValue['description']
                : null;
        } elseif (isset($parentValue['del'])) {
            $return = ['del' => 'Y'];
        } elseif (!empty($parentValue['description'])) {
            $return = ['description' => $parentValue['description']];
        }

        return $return;
    }

    /**
     * Возвращает информацию о файле из базы данных.
     *
     * @return array
     */
    protected function getDataBaseFileInfo()
    {
        $return = [];
        $value = $this->getImage();
        if (is_numeric($value)) {
            $arFile = CFile::GetFileArray($value);
            $sizes = [];
            if ($this->getWidth()) {
                $sizes['width'] = $this->getWidth();
            }
            if ($this->getHeight()) {
                $sizes['height'] = $this->getHeight();
            }
            if ($sizes) {
                $resize = CFile::ResizeImageGet($arFile, $sizes, BX_RESIZE_IMAGE_EXACT);
                $arFile['SRC'] = $resize['src'];
            }
            $return = $arFile;
        }

        return $return;
    }

    /**
     * @var int
     */
    protected $image = null;

    /**
     * @param int $value
     *
     * @return \marvin255\serviform\validators\Filter
     */
    public function setImage($value)
    {
        $this->image = (int) $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @var int
     */
    protected $width = null;

    /**
     * @param int $value
     *
     * @return \marvin255\serviform\validators\Filter
     */
    public function setWidth($value)
    {
        $this->width = (int) $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @var string
     */
    protected $removeLabel = 'Удалить изображение';

    /**
     * @param string $value
     *
     * @return \marvin255\serviform\validators\Filter
     */
    public function setRemoveLabel($value)
    {
        $this->removeLabel = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getRemoveLabel()
    {
        return $this->removeLabel;
    }

    /**
     * @var int
     */
    protected $height = null;

    /**
     * @param int $value
     *
     * @return \marvin255\serviform\validators\Filter
     */
    public function setHeight($value)
    {
        $this->height = (int) $value;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @var array
     */
    protected $containerAttributes = ['class' => 'bitrix_image_container'];

    /**
     * @param array $value
     *
     * @return \marvin255\serviform\validators\Filter
     */
    public function setContainerAttributes(array $value)
    {
        $this->containerAttributes = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getContainerAttributes()
    {
        return $this->containerAttributes;
    }

    /**
     * @var array
     */
    protected $description = [];

    /**
     * @param array $value
     *
     * @return \marvin255\serviform\bitrix\image\Field
     */
    public function setDescription($value)
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getDescription()
    {
        return $this->description;
    }
}
