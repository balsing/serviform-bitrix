<?php

namespace Marvin255Bxserviform;

use Bitrix\Main\Application;
use Bitrix\Main\Mail\Event;
use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use marvin255\serviform\helpers\FactoryFields;
use marvin255\serviform\interfaces\Field;
use CBitrixComponent;
use InvalidArgumentException;

/**
 * Базовый компонент для формы.
 */
class Form extends CBitrixComponent
{
    /**
     * @var \marvin255\serviform\interfaces\Field
     */
    protected $form;

    /**
     * {@inheritdoc}
     *
     * @throws \Bitrix\Main\LoaderException
     * @throws \InvalidArgumentException
     */
    public function onPrepareComponentParams($p)
    {
        if (!Loader::includeModule('marvin255.bxserviform')) {
            throw new LoaderException("Can't load module marvin255.bxserviform");
        }

        if (!isset($p['FORM_ARRAY'])) {
            $p['FORM_ARRAY'] = [];
        } elseif (!is_array($p['FORM_ARRAY'])) {
            throw new InvalidArgumentException('FORM_ARRAY param must be an array instance');
        }

        $p['SUCCESS_REDIRECT'] = !isset($p['SUCCESS_REDIRECT']) || trim($p['SUCCESS_REDIRECT']) === ''
            ? null
            : $p['SUCCESS_REDIRECT'];

        $p['FAIL_REDIRECT'] = !isset($p['FAIL_REDIRECT']) || trim($p['FAIL_REDIRECT']) === ''
            ? null
            : $p['FAIL_REDIRECT'];

        $p['ACTION'] = !isset($p['ACTION']) || trim($p['ACTION']) === ''
            ? null
            : $p['ACTION'];

        return parent::onPrepareComponentParams($p);
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     *
     * @throws \Exception
     */
    public function executeComponent()
    {
        $this->arResult = [];

        if (!$this->beforeExecuteComponent()) {
            return $this->arResult;
        }

        $form = $this->getForm();
        $data = $this->getRequestData();

        if (!$this->beforeProcessForm($form)) {
            return $this->arResult;
        }

        if ($form->loadData($data) && $form->validate()) {
            $processResult = $this->processForm($form);
            if ($url = $this->getRedirectUrl($processResult)) {
                $this->redirect($url);
            }
        }

        $this->arResult['form'] = $form;
        $this->arResult['data'] = $data;
        $this->arResult['result'] = !empty($processResult);

        if ($this->beforeTemplate()) {
            $this->includeComponentTemplate();
        }

        $this->beforeReturn();

        return $this->arResult;
    }

    /**
     * Выполняет действие над результатами формы.
     *
     * @param \marvin255\serviform\interfaces\Field $form
     *
     * @return bool
     */
    protected function processForm(Field $form)
    {
        return (bool) $form->getErrors();
    }

    /**
     * Создает почтовое событие.
     *
     * @param string $event
     * @param array  $params
     *
     * @return bool
     */
    protected function sendEvent($event, array $params)
    {
        $res = Event::send([
            'EVENT_NAME' => $event,
            'LID' => SITE_ID,
            'C_FIELDS' => $params,
        ]);

        return $res->isSuccess();
    }

    /**
     * Перенаправляет на указанную ссылку.
     *
     * @param string $url
     */
    protected function redirect($url = null)
    {
        $default = Application::getInstance()
            ->getContext()
            ->getRequest()
            ->getRequestUri();

        LocalRedirect($url ?: $default);
    }

    /**
     * Возвращает объект с формой.
     *
     * @return \marvin255\serviform\interfaces\Field
     */
    protected function getForm()
    {
        if ($this->form === null) {
            $this->form = FactoryFields::initElement(
                'form',
                $this->getFormArray()
            );
        }

        return $this->form;
    }

    /**
     * Возвращает данные для формы из запроса.
     *
     * @return array
     */
    protected function getRequestData()
    {
        return Application::getInstance()
            ->getContext()
            ->getRequest()
            ->getPostList()
            ->toArray();
    }

    /**
     * Возвращает параметр action для формы. По умолчанию - текущая страница
     * без парамтеров.
     *
     * @return string
     */
    protected function getAction()
    {
        if ($this->arParams['ACTION']) {
            $path = $this->arParams['ACTION'];
        } else {
            $path = Application::getInstance()
                ->getContext()
                ->getRequest()
                ->getRequestedPageDirectory();
        }
        $path = '/' . trim($path, '/') . '/';

        return $path;
    }

    /**
     * Возвращает массив для создания формы.
     *
     * @return array
     */
    protected function getFormArray()
    {
        return $this->arParams['FORM_ARRAY'];
    }

    /**
     * Вовзращает ссылку, на которую нужно перейти после обработки формы.
     *
     * @param int|bool $processResult
     *
     * @return string
     */
    protected function getRedirectUrl($processResult)
    {
        $return = null;
        if ($processResult && !empty($this->arParams['SUCCESS_REDIRECT'])) {
            $return = $this->arParams['SUCCESS_REDIRECT'];
        } elseif (!$processResult && !empty($this->arParams['FAIL_REDIRECT'])) {
            $return = $this->arParams['FAIL_REDIRECT'];
        }

        return $return;
    }

    /**
     * Перед выполнением компонента.
     *
     * @return bool
     */
    protected function beforeExecuteComponent()
    {
        return true;
    }

    /**
     * Перед обработкой формы.
     *
     * @param \marvin255\serviform\interfaces\Field $form
     *
     * @return bool
     */
    protected function beforeProcessForm(Field $form)
    {
        return true;
    }

    /**
     * Перед выполнением шаблона.
     *
     * @return bool
     */
    protected function beforeTemplate()
    {
        return true;
    }

    /**
     * Перед тем, как вернуть результат из формы.
     *
     * @return bool
     */
    protected function beforeReturn()
    {
        return true;
    }
}
