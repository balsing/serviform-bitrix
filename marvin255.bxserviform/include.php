<?php

use Bitrix\Main\Event;
use marvin255\serviform\helpers\FactoryFields;
use marvin255\serviform\helpers\FactoryValidators;
use marvin255\bxserviform;

require_once __DIR__ . '/serviform/Autoloader.php';

//captcha
FactoryFields::setDescription(
    'bitrix.captcha',
    ['type' => bxserviform\captcha\Field::class]
);
FactoryValidators::setDescription(
    'bitrix.captcha',
    ['type' => bxserviform\captcha\Validator::class]
);

//honeypot
FactoryFields::setDescription(
    'bitrix.honeypot',
    ['type' => bxserviform\honeypot\Field::class]
);
FactoryValidators::setDescription(
    'bitrix.honeypot',
    ['type' => bxserviform\honeypot\Field::Validator]
);

//изображение в формате битрикса
FactoryFields::setDescription(
    'bitrix.image',
    ['type' => bxserviform\image\Field::class]
);
FactoryValidators::setDescription(
    'bitrix.image',
    ['type' => bxserviform\image\Field::Validator]
);

//проверка уникальности колонки для orm
FactoryValidators::setDescription(
    'bitrix.ormunique',
    ['type' => bxserviform\ormunique\Validator::class]
);

//проверка csrf токена
FactoryFields::setDescription(
    'bitrix.session',
    ['type' => bxserviform\session\Field::class]
);
FactoryValidators::setDescription(
    'bitrix.session',
    ['type' => bxserviform\session\Validator::class]
);

//событие, которое позволяет заполнить переводы для ошибок или определить
//собственные поля и валидаторы
$event = new Event('marvin255.bxserviform', 'init', []);
$event->send();
