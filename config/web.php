<?php
# * ********************************************************************* *
# *                                                                       *
# *   Billing Portal                                                      *
# *   This file is part of billingportal. This project may be found at:   *
# *   https://github.com/IdentityBank/Php_billingportal.                  *
# *                                                                       *
# *   Copyright (C) 2020 by Identity Bank. All Rights Reserved.           *
# *   https://www.identitybank.eu - You belong to you                     *
# *                                                                       *
# *   This program is free software: you can redistribute it and/or       *
# *   modify it under the terms of the GNU Affero General Public          *
# *   License as published by the Free Software Foundation, either        *
# *   version 3 of the License, or (at your option) any later version.    *
# *                                                                       *
# *   This program is distributed in the hope that it will be useful,     *
# *   but WITHOUT ANY WARRANTY; without even the implied warranty of      *
# *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the        *
# *   GNU Affero General Public License for more details.                 *
# *                                                                       *
# *   You should have received a copy of the GNU Affero General Public    *
# *   License along with this program. If not, see                        *
# *   https://www.gnu.org/licenses/.                                      *
# *                                                                       *
# * ********************************************************************* *

################################################################################
# Use(s)                                                                       #
################################################################################

use idbyii2\helpers\Localization;

################################################################################
# Load params                                                                  #
################################################################################

$params = require(__DIR__ . '/params.php');

################################################################################
# Web Config                                                                   #
################################################################################

$config = [
    'id' => 'IDB - Billing',
    'name' => 'Identity Bank - Billing',
    'version' => '1.0.0',
    'vendorPath' => $yii . '/vendor',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'language' => BillingConfig::get()->getWebLanguage(),
    'sourceLanguage' => 'en-GB',
    'aliases' => [
        '@idbyii2' => '/usr/local/share/p57b/php/idbyii2',
    ],
    'modules' => [
        'idbuser' => [
            'class' => 'app\modules\idbuser\IdbUserModule',
            'controllerNamespace' => 'app\modules\idbuser\controllers',
            'configUserAccount' => BillingConfig::get()->getYii2BillingModulesIdbUserConfigUserAccount(),
            'configUserData' => BillingConfig::get()->getYii2BillingModulesIdbUserConfigUserData(),
        ],
        'business' => [
            'class' => 'app\modules\business\BusinessModule',
        ],
        'credit' => [
            'class' => 'app\modules\credit\CreditModule',
        ],
        'package' => [
            'class' => 'app\modules\package\PackageModule',
        ],
        'invoice' => [
            'class' => 'app\modules\invoice\InvoiceModule',
        ],
        'payment' => [
            'class' => 'app\modules\payment\PaymentModule',
        ],
    ],
    'components' => [
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'forceCopy' => BillingConfig::get()->isAssetManagerForceCopy(),
            'appendTimestamp' => true,
        ],
        'idbbusinessportalapi' => [
            'class' => 'idbyii2\components\PortalApi',
            'configuration' => BillingConfig::get()->getBusinessPortalApiConfiguration(),
        ],
        'audit' => [
            'class' => 'idbyii2\audit\AuditComponent',
            'auditConfig' => [
                'class' => 'idbyii2\audit\AuditConfig',
                'enabled' => BillingConfig::get()->isAuditEnabled(),
            ],
            'auditFile' => [
                'class' => 'idbyii2\audit\FileAudit',
                'auditPath' => BillingConfig::get()->getAuditPath(),
                'auditFile' => BillingConfig::get()->getAuditFileName(),
            ],
            'auditMessage' => [
                'class' => 'idbyii2\audit\AuditMessage',
                'liveServerLog' => !BillingConfig::get()->isDebug(),
                'separator' => BillingConfig::get()->getAuditMessageSeparator(),
                'encrypted' => BillingConfig::get()->isAuditEncrypted(),
                'password' => BillingConfig::get()->getAuditMessagePassword(),
            ],
        ],
        'request' => [
            'cookieValidationKey' => BillingConfig::get()->getYii2BillingCookieValidationKey(),
        ],
        'idbmessenger' => [
            'class' => 'idbyii2\components\Messenger',
            'configuration' => BillingConfig::get()->getMessengerConfiguration(),
        ],
        'idbrabbitmq' => [
            'class' => 'idbyii2\components\IdbRabbitMq',
            'host' => BillingConfig::get()->getIdbRabbitMqHost(),
            'port' => BillingConfig::get()->getIdbRabbitMqPort(),
            'user' => BillingConfig::get()->getIdbRabbitMqUser(),
            'password' => BillingConfig::get()->getIdbRabbitMqPassword()
        ],
        'db' => require(__DIR__ . '/db_p57b_billing.php'), //RBAC
        'p57b_billing' => require(__DIR__ . '/db_p57b_billing.php'),
        'p57b_billing_search' => require(__DIR__ . '/db_p57b_billing.php'),
        'p57b_billing_log' => require(__DIR__ . '/db_p57b_billing.php'),
        'idbillclient' => [
            'class' => 'idbyii2\models\idb\BillingIdbBillingClient',
            'billingName' => BillingConfig::get()->getIdBillingName(),
            'host' => BillingConfig::get()->getIdBillHost(),
            'port' => BillingConfig::get()->getIdBillPort(),
            'configuration' => BillingConfig::get()->getIdBillConfiguration()
        ],
        'user' => [
            'identityClass' => 'idbyii2\models\identity\IdbBillingUser',
            'enableAutoLogin' => BillingConfig::get()->getYii2BillingEnableAutoLogin(),
            'identityCookie' => ['name' => '_billing_identity-p57b', 'httpOnly' => true],
            'absoluteAuthTimeout' => BillingConfig::get()->getYii2BillingAbsoluteAuthTimeout(),
            'authTimeout' => BillingConfig::get()->getYii2BillingAuthTimeout(),
            'loginUrl' => BillingConfig::get()->getLoginUrl(),
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['idb_bill'],
            'cache' => YII_DEBUG ? null : 'cache',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'rules' => [
                'defaultRoute' => '/site/index',
                'login' => '/site/login',
                'mfa' => '/site/mfa',
                'logout' => '/site/logout',
                'idb-login' => '/site/idb-login',
                'idb-api' => '/site/idb-api',
                'profile' => '/site/profile'
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\ApcCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logVars' => [],
                    'categories' => ['billing'],
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/info.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 10,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logVars' => [],
                    'levels' => ['error', 'warning'],
                    'logFile' => '/var/log/p57b/p57b.billing-errors.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logVars' => [],
                    'levels' => ['trace', 'info'],
                    'logFile' => '/var/log/p57b/p57b.billing-debug.log',
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'billing' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'sourceLanguage' => 'en-GB',
                    'basePath' => '@app/messages',
                ],
                'idbyii2' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'sourceLanguage' => 'en-GB',
                    'basePath' => '@idbyii2/messages',
                ],
                'idbexternal' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'forceTranslation' => true,
                    'sourceLanguage' => 'en-GB',
                    'basePath' => '@idbyii2/messages',
                ],
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:' . Localization::getDateFormat(),
            'datetimeFormat' => 'php:' . Localization::getDateTimeFormat(false),
            'timeFormat' => 'php:' . Localization::geTimeFormat(false),
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'EUR',
        ],
    ],
    'params' => $params,
];

if (defined('APP_THEME')) {
    switch (APP_THEME) {
        case 'default':
        default:
        {
        }
    }
}

if (defined('APP_LANGUAGE')) {
    $config['language'] = APP_LANGUAGE;
}

if (YII_ENV_DEV) {
    $allowedIPs = ['127.0.0.1', '::1'];
    if (!empty(BillingConfig::get()->getYii2SecurityGiiAllowedIP())) {
        $allowedIPs [] = BillingConfig::get()->getYii2SecurityGiiAllowedIP();
    }

    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => $allowedIPs
    ];
}

$config['bootstrap'] = ['log'];
$config['on beforeRequest'] = function ($event) {
    idbyii2\models\db\BillingModel::initModel();
};

return $config;

################################################################################
#                                End of file                                   #
################################################################################
