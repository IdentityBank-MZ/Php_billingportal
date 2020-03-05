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
# Include(s)                                                                   #
################################################################################

include_once 'simplelog.inc';
include_once 'jsonsimpleconfig.inc';
include_once 'idbyii2/helpers/IdbYii2Config.php';

################################################################################
# Use(s)                                                                       #
################################################################################

use idbyii2\helpers\IdbAccountNumberDestination;
use idbyii2\helpers\IdbYii2Config;
use function xmz\simplelog\logLevel;
use function xmz\simplelog\registerLogger;

################################################################################
# Local Config                                                                 #
################################################################################

const billingConfigFile = '/etc/p57b/billing.jsc';
const billingConfigFileDefault = 'config.jsc';

################################################################################
# Class(es)                                                                    #
################################################################################

/**
 * Class BillingConfig
 */
class BillingConfig extends IdbYii2Config
{

    private static $instance;

    /**
     * BillingConfig constructor.
     */
    final protected function __construct()
    {
        parent::__construct();
        $this->mergeJscFile(
            dirname(__FILE__) . '/'
            . billingConfigFileDefault
        );
        $this->mergeJscFile(billingConfigFile);
        registerLogger($this->getLogName(), $this->getLogPath());
        logLevel($this->getLogLevel());
    }

    public static function get()
    {
        if (!isset(self::$instance) || !self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    function isDebug()
    {
        return $this->getValue(null, 'debug', false);
    }

    function isAssetManagerForceCopy()
    {
        return $this->getValue(null, 'assetManagerForceCopy', false);
    }

    function isYiiErrorHandlerEnabled()
    {
        return $this->getValue(null, 'yiiEnableErrorHandler', true);
    }

    function getLogLevel()
    {
        return $this->getValue("Log", "logLevel");
    }

    function getLogName()
    {
        return $this->getValue("Log", "logName");
    }

    function getLogPath()
    {
        return $this->getValue("Log", "logPath");
    }

    function getTheme()
    {
        return $this->getValue(null, 'theme', "default");
    }

    function getThemeErrorPage()
    {
        return $this->getValue(null, 'themeErrorPage', 6);
    }

    function getLoginUrl()
    {
        return $this->getValue(null, 'loginUrl', ['/login']);
    }

    function useBrowserLocalization()
    {
        return $this->getValue('Localization', 'browser');
    }

    function getDefaultLocalizationLanguage()
    {
        return $this->getValue('Localization', 'defaultLanguage');
    }

    function getLocalizationLanguage()
    {
        return $this->getValue('Localization', 'language', $this->getDefaultLocalizationLanguage());
    }

    function getWebLanguage()
    {
        return $this->getValue('Localization', 'webLanguage', $this->getDefaultLocalizationLanguage());
    }

    function isAuditEnabled()
    {
        return $this->getValue('Audit', 'enabled', false);
    }

    function isAuditEncrypted()
    {
        return $this->getValue('Audit', 'messageEncrypted', false);
    }

    function getAuditMessagePassword()
    {
        return $this->getValue('Audit', 'messagePassword', 'password');
    }

    function getAuditMessageSeparator()
    {
        return $this->getValue('Audit', 'messageSeparator', ']|[');
    }

    function getAuditPath()
    {
        return $this->getValue('Audit', 'auditPath');
    }

    function getAuditFileName()
    {
        return $this->getValue('Audit', 'auditFile', 'yii2_billing_audit.log');
    }

    function getYii2BillingCookieValidationKey()
    {
        return $this->getValue('"Yii2"."billing"', 'cookieValidationKey');
    }

    function isIdentityByAccessTokenEnabled()
    {
        return $this->getValue('"Yii2"."billing"', 'identityByAccessTokenEnabled');
    }

    function getYii2BillingEnableAutoLogin()
    {
        return $this->getValue('"Yii2"."billing"', 'enableAutoLogin', false);
    }

    function getYii2BillingAbsoluteAuthTimeout()
    {
        return $this->getValue('"Yii2"."billing"', 'absoluteAuthTimeout', 43200);
    }

    function getYii2BillingAuthTimeout()
    {
        return $this->getValue('"Yii2"."billing"', 'authTimeout', 3600);
    }

    function getYii2BillingAccountId()
    {
        return $this->getValue('"Yii2"."billing"', 'accountId');
    }

    function passwordPolicy()
    {
        return $this->getValue('"Yii2"."billing"', 'passwordPolicy');
    }

    function getYii2IdbSecurityMagicShift()
    {
        return $this->getValue('"Yii2"."security"."idb"', 'magic_shift', 5);
    }

    function getYii2BillingSearchPassword()
    {
        return $this->getValue('"Yii2"."security"."idb"', 'search_password', 'password');
    }

    function getYii2BillingSearchBlowfishCost()
    {
        return $this->getValue('"Yii2"."security"."idb"', 'search_blowfish', 1);
    }

    function getYii2BillingLogPassword()
    {
        return $this->getValue('"Yii2"."security"."idb"', 'log_password', 'password');
    }

    function getYii2BillingLogBlowfishCost()
    {
        return $this->getValue('"Yii2"."security"."idb"', 'log_blowfish', 1);
    }

    function getIdBillingName()
    {
        return $this->getValue('"IDBill"."IdbBillingClient"', 'name', 'p57b');
    }

    function getIdBillHost()
    {
        return $this->getValue('"IDBill"."IdbBillingClient"', 'host', '127.0.0.1');
    }

    function getIdBillPort()
    {
        return $this->getValue('"IDBill"."IdbBillingClient"', 'port', 87);
    }

    function getYii2BillingModulesIdbUserConfigUserAccount()
    {
        $configUserAccount = $this->getValue('"Yii2"."billing"."modules"."idbuser"', 'configUserAccount');
        if ((!empty($configUserAccount)) && (is_array($configUserAccount))) {
            return $configUserAccount;
        }

        return null;
    }

    function getYii2BillingModulesIdbUserConfigUserData()
    {
        $configUserData = $this->getValue('"Yii2"."billing"."modules"."idbuser"', 'configUserData');
        if ((!empty($configUserData)) && (is_array($configUserData))) {
            return $configUserData;
        }

        return null;
    }

    function getYii2MfaIssuer($portal = IdbAccountNumberDestination::billing)
    {
        return parent::getYii2MfaIssuer(IdbAccountNumberDestination::billing);
    }
}

################################################################################
#                                End of file                                   #
################################################################################
