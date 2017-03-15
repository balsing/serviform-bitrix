<?php

use marvin255\serviform\helpers\FactoryValidators;
use marvin255\serviform\helpers\FactoryFields;

//inject bitrix session field
FactoryFields::setDescription(
    'bitrix.session',
    ['type' => '\marvin255\serviform\bitrix\session\Field']
);

//inject bitrix captcha field
FactoryFields::setDescription(
    'bitrix.captcha',
    ['type' => '\marvin255\serviform\bitrix\captcha\Field']
);