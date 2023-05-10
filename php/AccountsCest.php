<?php

/**
 * Copyright (c) 2020 by PROS, Inc.  All Rights Reserved.
 * This software is the confidential and proprietary information of
 * PROS, Inc. ("Confidential Information").
 * You may not disclose such Confidential Information, and may only
 * use such Confidential Information in accordance with the terms of
 * the license agreement you entered into with PROS.
 */

namespace Tests\acceptance\UserManagement;

use AcceptanceTester;
use Params\GlobalParams;
use Models\AcceptanceCest;
use Locators\GlobalLocators;
use Locators\AccountsLocators;
use Locators\ApiUsersLocators;
use Params\UserManagementParams;
use Properties\UserManagementFunctions;

class AccountsCest extends AcceptanceCest
{
    use UserManagementFunctions;

    private const TEST_ACCOUNT = '2_testAccount';
    private const SUCCESS_MSG = 'Account was saved successfully!';

    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/v5/logout');
        $I->executeJS("window.localStorage.removeItem('userPreferences')");
        $this->loginAndNavigate($I, 'ManagerWeb', GlobalParams::USER_MANAGEMENT, GlobalParams::ACCOUNTS_MODULE);
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6913
     */
    public function createNewAccountDefaultParams(AcceptanceTester $I)
    {
        $account = 'automatedTestAccount'; 

        $I->amGoingTo('Create new Account');
        $this->clickAndWait($I, GlobalLocators::HEADER_NEW_BUTTON);
        $this->fillFieldAndWait($I, GlobalParams::ACCOUNT_CLASS_FIELD,  $account);
        $this->fillFieldAndWait($I, 'company', 'testCompany');
        $I->click(GlobalLocators::HEADER_SAVE_BUTTON);
        $this->verifyMessage($I, self::SUCCESS_MSG);
        $this->useBreadcrumbs($I, GlobalParams::ACCOUNTS_MODULE);
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD,  $account);
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6914
     */
    public function editAccountConfiguration(AcceptanceTester $I)
    {
        $I->amGoingTo('Edit Account Configuration');
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, GlobalParams::TEST_ACCOUNT);
        $this->clickAndWait($I, $this->generateActionLocator(GlobalParams::TEST_ACCOUNT, UserManagementParams::EDIT));
        $this->selectDropdownOption(
            $I,
            AccountsLocators::PRODUCTS_FIELD,
            AccountsLocators::PRODUCTS_FIELD_INPUT,
            'Fast Search'
        );
        $I->wait(GlobalParams::SHORT_WAIT);
        $this->selectDropdownOption(
            $I,
            AccountsLocators::PRODUCTS_FIELD,
            AccountsLocators::PRODUCTS_FIELD_INPUT,
            GlobalParams::MER_ACCOUNT
        );
        $this->setStatus($I, 'Active');
        $this->seeSettingsDisplayed($I, 'Fast Search Settings');
        $this->seeSettingsDisplayed($I, 'Merchandising Settings');
        $this->selectDropdownOption(
            $I,
            AccountsLocators::PRODUCTS_FIELD,
            AccountsLocators::PRODUCTS_FIELD_INPUT,
            'Repricer'
        );
        $this->selectDropdownOption(
            $I,
            AccountsLocators::PRODUCTS_FIELD,
            AccountsLocators::PRODUCTS_FIELD_INPUT,
            'Availability'
        );
        $I->wait(GlobalParams::SHORT_WAIT);
        $I->click(AccountsLocators::DEMO_RADIOBUTTON);
        $I->seeElement(AccountsLocators::DEMO_CHECKED);
        $this->seeSettingsDisplayed($I, 'Availability Settings');
        $I->click($this->generateLocator(GlobalLocators::$text, 'Repricer Settings'));
        $this->fillAndWait($I, 'Endpoint', 'endpoint');
        $this->selectDropdownOption(
            $I,
            AccountsLocators::CLIENT_ACCOUNTS,
            AccountsLocators::CLIENT_ACCOUNTS_INPUT,
            GlobalParams::ACCOUNT
        );
        $I->click(GlobalLocators::HEADER_SAVE_BUTTON);
        $this->verifyMessage($I, self::SUCCESS_MSG);
        $this->useBreadcrumbs($I, GlobalParams::ACCOUNTS_MODULE);
        $this->assertElementPresent($I, 'Fast Search, Merchandising, Repricer, Availability');
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6915
     */
    public function viewAccount(AcceptanceTester $I)
    {
        $I->amGoingTo('View created Account');
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, GlobalParams::TEST_ACCOUNT);
        $this->clickAndWait($I, $this->generateActionLocator(GlobalParams::TEST_ACCOUNT, UserManagementParams::VIEW));
        $accountFieldDiasabled = $this->generateLocator(GlobalLocators::$disabledField, GlobalParams::ACCOUNT_CLASS_FIELD);
        $I->seeElement($accountFieldDiasabled);
        try {
            $I->fillField($accountFieldDiasabled, 'test');
        } catch (\Exception $e) {
            $I->comment(UserManagementParams::DISABLED_FIELD_MSG);
        }
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6916
     */
    public function addFeatures(AcceptanceTester $I)
    {
        $I->amGoingTo('Edit Account Configuration');
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, self::TEST_ACCOUNT);
        $this->clickAndWait(
            $I,
            $this->generateActionLocator(self::TEST_ACCOUNT, UserManagementParams::EDIT)
        );
        $this->checkCheckboxFeatures($I, 'Dashboard activity widget');
        $this->checkCheckboxFeatures($I, 'AVL expirations menu');
        $this->checkCheckboxFeatures($I, 'Dashboard transactions widget');
        $I->click($this->seeSettingsDisplayed($I, 'One Search Settings'));
        $this->checkCheckboxFeatures($I, 'Repricer Result Control in BRE');
        $this->checkCheckboxFeatures($I, 'Export of Business Rules');
        $I->click($this->seeSettingsDisplayed($I, 'Fast Search Settings'));
        $this->checkCheckboxFeatures($I, 'Order Units');
        $this->checkCheckboxFeatures($I, 'Bulk Regenerate Pairs');
        $this->checkCheckboxFeatures($I, 'CSV import pairs');
        $I->click($this->seeSettingsDisplayed($I, 'One Search Settings'));
        $I->click($this->seeSettingsDisplayed($I, 'Fast Search Settings'));
        $I->click($this->seeSettingsDisplayed($I, 'Merchandising Settings'));
        $this->checkCheckboxFeatures($I, 'Enable Offer Optimisation');
        $I->wait(GlobalParams::MICRO_WAIT);
        $this->fillAndWait($I, 'Endpoint', 'endpoint');
        $I->click(GlobalLocators::HEADER_SAVE_BUTTON);
        $this->verifyMessage($I, self::SUCCESS_MSG);
        $I->reloadPage();
        $this->assertCheckedFeatures($I, 'Dashboard activity widget');
        $I->click($this->seeSettingsDisplayed($I, 'Fast Search Settings'));
        $this->assertCheckedFeatures($I, 'Order Units');
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6919
     */
    public function editReportsAndStatistics(AcceptanceTester $I)
    {
        $I->amGoingTo('Edit Reports and Statistics configuration');
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, self::TEST_ACCOUNT);
        $I->click($this->generateActionLocator(self::TEST_ACCOUNT, UserManagementParams::EDIT));
        $this->goToUserManagementTab($I, 'reports');
        $I->click($this->generateLocator(GlobalLocators::$text, 'One Search'));
        $I->click($this->generateLocator(GlobalLocators::$text, GlobalParams::MER_ACCOUNT));
        $this->setApiUsersReportsAndStatistics($I, 'Include', 'Onesearch API Users', GlobalParams::AUTO_API_USER);
        $this->setApiUsersReportsAndStatistics(
            $I,
            'Exclude',
            'Fastsearch API Users',
            UserManagementParams::USER
        );
        $I->wait(GlobalParams::WAIT);
        $I->click(GlobalLocators::HEADER_SAVE_BUTTON);
        $this->verifyMessage($I, self::SUCCESS_MSG);
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6917
     */
    public function deleteAccount(AcceptanceTester $I)
    {
        $I->amGoingTo('Delete Account');
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, self::TEST_ACCOUNT);
        $this->clickAndWait($I, $this->generateActionLocator(self::TEST_ACCOUNT, 'delete'));
        $this->clickAndVerifyMessage($I, GlobalLocators::DELETE, GlobalParams::DELETE_MSG);
        //Status field on Listing tab
        $this->assertElementPresent($I, UserManagementParams::STATUS_DEL);
        $I->click(
            $this->generateActionLocator(self::TEST_ACCOUNT, UserManagementParams::EDIT, 'Deleted')
        );
        //Status filed on Account Configuration tab
        $this->assertElementPresent($I, UserManagementParams::STATUS_DEL);
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6918
     */
    public function crudAccount(AcceptanceTester $I)
    {
        $name = '5_testAccount';
        $I->amGoingTo('Create, edit and delete Account');
        // ==== create ====
        $this->clickAndWait($I, GlobalLocators::HEADER_NEW_BUTTON);
        $this->fillFieldAndWait($I, GlobalParams::ACCOUNT_CLASS_FIELD, $name);
        $this->fillFieldAndWait($I, 'company', 'testCompany');
        $I->click(GlobalLocators::HEADER_SAVE_BUTTON);
        $this->verifyMessage($I, self::SUCCESS_MSG);
        // ==== edit ====
        $this->useBreadcrumbs($I, GlobalParams::ACCOUNTS_MODULE);
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, $name);
        $I->click($this->generateActionLocator($name, UserManagementParams::EDIT));
        $this->selectDropdownOption(
            $I,
            AccountsLocators::PRODUCTS_FIELD,
            AccountsLocators::PRODUCTS_FIELD_INPUT,
            'One Search'
        );
        $I->wait(GlobalParams::SHORT_WAIT);
        $I->click($this->seeSettingsDisplayed($I, 'One Search Settings'));
        $this->checkCheckboxFeatures($I, 'Custom POS Currencies');
        $this->checkCheckboxFeatures($I, 'Flight Ranks');
        $this->checkCheckboxFeatures($I, 'Export of Business Rules');
        $I->click(GlobalLocators::HEADER_SAVE_BUTTON);
        $this->verifyMessage($I, self::SUCCESS_MSG);
        // ==== delete ====
        $this->useBreadcrumbs($I, GlobalParams::ACCOUNTS_MODULE);
        $this->clickAndWait($I, $this->generateActionLocator($name, 'delete', 'testCompany'));
        $this->clickAndVerifyMessage($I, GlobalLocators::DELETE, GlobalParams::DELETE_MSG);
        $this->assertElementPresent($I, UserManagementParams::STATUS_DEL);
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6921
     */
    public function goToWebUsersTab(AcceptanceTester $I)
    {
        $I->amGoingTo('Login users Tab');
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, GlobalParams::ACCOUNT);
        $I->click($this->generateActionLocator(GlobalParams::ACCOUNT, UserManagementParams::EDIT));
        $this->goToUserManagementTab($I, 'login');
        $this->assertElementPresent($I, UserManagementParams::MANAGER);
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6923
     */
    public function goToLoginUsersTab(AcceptanceTester $I)
    {
        $I->amGoingTo('FastSearch Login Users Tab');
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, GlobalParams::ACCOUNT);
        $I->click($this->generateActionLocator(GlobalParams::ACCOUNT, UserManagementParams::EDIT));
        $this->goToUserManagementTab($I, 'fs_api');
        $this->assertElementPresent($I, GlobalParams::USER);
        $this->assertElementPresent($I, UserManagementParams::USER);
        $this->assertElementPresent($I, UserManagementParams::MANAGER);
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6922
     */
    public function goToApiUsersTab(AcceptanceTester $I)
    {
        $I->amGoingTo('OneSearch Api Users Tab');
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, GlobalParams::ACCOUNT);
        $I->click($this->generateActionLocator(GlobalParams::ACCOUNT, UserManagementParams::EDIT));
        $this->goToUserManagementTab($I, 'os_api');
        $this->assertElementPresent($I, GlobalParams::API_USER);
        $this->assertElementPresent($I, GlobalParams::ADMIN_API_USER);
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6924
     */
    public function filterByCompany(AcceptanceTester $I)
    {
        $I->amGoingTo('Filter by Promo Combination Limit value');
        $this->searchFilter($I, 'Company', UserManagementParams::COMPANY);
        $companyList = $I->grabMultiple(GlobalLocators::LIST . '[3]');
        foreach ($companyList as $company) {
            $I->assertEquals(UserManagementParams::COMPANY, $company);
        }
    }

    /**
     * @group CodeCoverage
     * @group Accounts
     * @JiraTC_WEB-6925
     */
    public function filterByAccount(AcceptanceTester $I)
    {
        $I->amGoingTo('Filter by Account name');
        $this->searchFilter($I, GlobalParams::ACCOUNT_FIELD, GlobalParams::ACCOUNT);
        $accountsList = $I->grabMultiple(GlobalLocators::LIST . '[2]');
        foreach ($accountsList as $account) {
            $I->assertEquals(GlobalParams::ACCOUNT, $account);
        }
    }

    #region Helper Methods

    /**
     * @param AcceptanceTester $I
     * @param string $settingsName is the name of Product Settings box
     */
    protected function seeSettingsDisplayed(AcceptanceTester $I, $settingsName)
    {
        $setting = '//td[text()=\'' . $settingsName . '\']';
        $I->seeElement($setting);
        return $setting;
    }

    /**
     * @param AcceptanceTester $I
     * @param string $feauture is Account Feature for example: Dashboard activity widget, Order Units
     */
    protected function checkCheckboxFeatures(AcceptanceTester $I, $feature)
    {
        $featureCheckbox = '//p[text()=\'' . $feature . '\']/../..//div[@role=\'checkbox\']';
        $I->checkOption($featureCheckbox);
        return $featureCheckbox;
    }

    /**
     * @param AcceptanceTester $I
     * @param string $feauture is Account Feature for example: Dashboard activity widget, Order Units
     */
    protected function assertCheckedFeatures(AcceptanceTester $I, $feature)
    {
        $featureCheckbox = '//div[@aria-label = \'' . $feature . '\' and contains(@class, \'checked\')]';
        $I->seeElement($featureCheckbox);
    }

    /**
     * @param AcceptanceTester $I 
     * @param string $action is Include or Exclude Api User
     * @param string $apiUsers  can be Onesearch Api Users or Fastsearch Api Users
     */
    protected function setApiUsersReportsAndStatistics(AcceptanceTester $I, $action, $apiUsers, $apiUserName)
    {

        $I->click(str_replace(['$$', '##'], [$apiUsers, $action], ApiUsersLocators::$apiUserSelect));
        $I->wait(GlobalParams::WAIT);
        $I->click('//div[text()=\'' . $apiUserName . '\']');
    }

    #endregion Helper Methods
}
