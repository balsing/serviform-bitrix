<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

/**
 * Установщик для модуля marvin255.bxserviform.
 */
class marvin255_bxserviform extends CModule
{
    /**
     * @inheritdoc
     */
    public function __construct()
    {
        Loc::loadMessages(__FILE__);

        $arModuleVersion = [];
        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_ID = 'marvin255.bxserviform';
        $this->MODULE_NAME = Loc::getMessage('MARVIN255_BXSERVIFORM_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MARVIN255_BXSERVIFORM_MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME = Loc::getMessage('MARVIN255_BXSERVIFORM_MODULE_PARTNER_NAME');
    }

    /**
     * Устанавливает данные модуля в базу данных сайта.
     */
    public function installDb()
    {
    }

    /**
     * Удаляет данные модуля из базы данных сайта.
     */
    public function unInstallDb()
    {
        //удаляем все опции модуля
        Option::delete($this->MODULE_ID);
    }

    /**
     * Копирует файлы модуля в битрикс.
     *
     * @retrun bool
     */
    public function installFiles()
    {
        $components = $this->getInstallatorPath() . '/components';
        if (is_dir($components)) {
            CopyDirFiles(
                $components,
                $this->getComponentPath('components') . "/{$this->MODULE_ID}",
                true,
                true
            );
        }

        return true;
    }

    /**
     * Удаляет файлы модуля из битрикса.
     *
     * @retrun bool
     */
    public function unInstallFiles()
    {
        $components = $this->getComponentPath('components') . "/{$this->MODULE_ID}";
        if (is_dir($components)) {
            Directory::deleteDirectory($components);
        }

        return true;
    }

    /**
     * Возвращает путь к папке, в которую будут установлены компоненты модуля.
     *
     * @param string $type тип компонентов для установки (components, js, admin и т.д.)
     *
     * @return string
     */
    protected function getComponentPath($type = 'components')
    {
        if ($type === 'admin') {
            $base = Application::getDocumentRoot() . '/bitrix';
        } else {
            $base = dirname(dirname(dirname($this->getInstallatorPath())));
        }

        return $base . '/' . str_replace(['/', '.'], '', $type);
    }

    /**
     * Возвращает путь к папке с модулем
     *
     * @return string
     */
    protected function getInstallatorPath()
    {
        return __DIR__;
    }

    /**
     * @inheritdoc
     */
    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        $this->installFiles();
        $this->installDb();
    }

    /**
     * @inheritdoc
     */
    public function DoUninstall()
    {
        $this->unInstallDb();
        $this->unInstallFiles();
        ModuleManager::unregisterModule($this->MODULE_ID);
    }
}
