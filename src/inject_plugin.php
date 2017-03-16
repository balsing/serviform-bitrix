<?php

use marvin255\serviform\helpers\FactoryFields;
use marvin255\serviform\helpers\FactoryValidators;


//inject bitrix session field
FactoryFields::setDescription(
    'bitrix.session',
    ['type' => '\marvin255\serviform\bitrix\session\Field']
);
//inject bitrix session validator
FactoryValidators::setDescription(
    'bitrix.session',
    ['type' => '\marvin255\serviform\bitrix\session\Validator']
);


//inject bitrix captcha field
FactoryFields::setDescription(
    'bitrix.captcha',
    ['type' => '\marvin255\serviform\bitrix\captcha\Field']
);
//inject bitrix captcha validator
FactoryValidators::setDescription(
    'bitrix.captcha',
    ['type' => '\marvin255\serviform\bitrix\captcha\Validator']
);


//inject bitrix ormunique validator
FactoryValidators::setDescription(
    'bitrix.ormunique',
    ['type' => '\marvin255\serviform\bitrix\ormunique\Validator']
);
