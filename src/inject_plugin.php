<?php

use marvin255\serviform\helpers\FactoryFields;
use marvin255\serviform\helpers\FactoryValidators;

//inject bitrix captcha field
FactoryFields::setDescription(
    'bitrix.captcha',
    ['type' => '\\marvin255\\serviform\\bitrix\\captcha\\Field']
);
//inject bitrix captcha validator
FactoryValidators::setDescription(
    'bitrix.captcha',
    ['type' => '\\marvin255\\serviform\\bitrix\\captcha\\Validator']
);

//inject bitrix honey pot field
FactoryFields::setDescription(
    'bitrix.honeypot',
    ['type' => '\\marvin255\\serviform\\bitrix\\honeypot\\Field']
);
//inject bitrix honey pot validator
FactoryValidators::setDescription(
    'bitrix.honeypot',
    ['type' => '\\marvin255\\serviform\\bitrix\\honeypot\\Validator']
);

//inject bitrix image validator
FactoryFields::setDescription(
    'bitrix.image',
    ['type' => '\\marvin255\\serviform\\bitrix\\image\\Field']
);
//inject bitrix image validator
FactoryValidators::setDescription(
    'bitrix.image',
    ['type' => '\\marvin255\\serviform\\bitrix\\image\\Validator']
);

//inject bitrix ormunique validator
FactoryValidators::setDescription(
    'bitrix.ormunique',
    ['type' => '\\marvin255\\serviform\\bitrix\\ormunique\\Validator']
);

//inject bitrix session field
FactoryFields::setDescription(
    'bitrix.session',
    ['type' => '\\marvin255\\serviform\\bitrix\\session\\Field']
);
//inject bitrix session validator
FactoryValidators::setDescription(
    'bitrix.session',
    ['type' => '\\marvin255\\serviform\\bitrix\\session\\Validator']
);
