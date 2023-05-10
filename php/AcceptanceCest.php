<?php
/**
 * Copyright (c) 2019-2020 by PROS, Inc.  All Rights Reserved.
 * This software is the confidential and proprietary information of
 * PROS, Inc. ("Confidential Information").
 * You may not disclose such Confidential Information, and may only
 * use such Confidential Information in accordance with the terms of
 * the license agreement you entered into with PROS.
 */

namespace Models;

use AcceptanceTester;
use Exception;
use Locators\GlobalLocators;
use Traits\Login;
use Traits\Params;
use Properties\Modules;
use Properties\Functions;
use Properties\ButtonsFields;
use Params\GlobalParams;
use Facebook\WebDriver\WebDriverKeys;

/**
 * Class AcceptanceCest
 * @package Models
 */
class AcceptanceCest
{
    use Login;
    use Params;
    use Modules;
    use Functions;
    use ButtonsFields;

    const ADMIN_TEST_ACCOUNT = 'AdminTestAccount';

    const USER_CLIENT = 'Client';
    const USER_MANAGER = 'Manager';
    const USER_MER_CLIENT = 'MerClient';
    const USER_MER_USE_CASE = 'MerUseCase';
    const USER_MANAGER_WEB = 'ManagerWeb';
    const USER_MANAGER_TEST = 'ManagerTest';
    const USER_PRECOMPUTED = 'PrecomputedUser';
    const USER_CORESEARCH = 'CoreSearchUser';
    const USER_REPRICER = 'RepricerUser';
    const USER_MER_WEB = 'MerchandisingUser';
    const USER_TEST_PASS = "testPassUser";
    const USER_ADMIN = 'Admin';
    const REPRICER_READ = 'RepricerRead';
    
    const WEB_PASSWORD = 'Testweb20@';

    /**
     * @var array Login credentials
     */
    public static $credentials = [
        self::USER_ADMIN => [
            'user' => 'admintest@vayant.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_CLIENT => [
            'user' => 'admintestclient@vayant.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_MANAGER => [
            'user' => 'managerLoginUser@pros.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_MER_CLIENT => [
            'user' => 'merchandisingClient@pros.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_MER_USE_CASE => [
            'user' => 'merchusecaseclient@pros.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_MANAGER_WEB => [
            'user' => 'managerLoginUser@pros.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_MANAGER_TEST => [
            'user' => 'autoWebUser@vayant.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_PRECOMPUTED => [
            'user' => 'precomputedUser@vayant.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_CORESEARCH => [
            'user' => 'coreSearchUser@vayant.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_REPRICER => [
            'user' => 'repricerUser@vayant.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_MER_WEB => [
            'user' => 'merchwebautologinuser@vayant.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::USER_TEST_PASS => [
            'user' => 'testPasswordUser@vayant.com',
            'pass' => self::WEB_PASSWORD,
        ],
        self::REPRICER_READ  => [
            'user' => 'repricerRead@vayant.com',
            'pass' => self::WEB_PASSWORD,
        ]
    ];

    /**
     * Needed because it is used as a fallback of the legacy "doLogin" method.
     *
     * @param AcceptanceTester $I
     * @param $userType
     */
    public function _login(AcceptanceTester $I, $usertype)
    {
        $this->login($I, $usertype);
    }

    /**
     * @param AcceptanceTester $I
     * @param $userType
     * @throws Exception
     */
    protected function login(AcceptanceTester $I, $userType): void
    {
        // Validate user type
        if (!isset(self::$credentials[$userType])) {
            $I->comment('Invalid user type!');
            $I->assertTrue(false);
            return;
        }

        $username = self::$credentials[$userType]['user']; //'managerLoginUser@pros.com';
        $password = self::$credentials[$userType]['pass']; //'Password123!A';

        // Login user
        $I->amOnPage('/v5/logout');
        $I->amGoingTo('login with username ' . $username);
        $I->waitForElementVisible(GlobalLocators::$loginUserInput, GlobalParams::LONG_WAIT);
        $I->fillField(GlobalLocators::$loginUserInput, $username);
        $this->waitAndClick($I, GlobalLocators::$loginButton);
        $I->waitForElement(GlobalLocators::$loginPassInput, GlobalParams::LONG_WAIT);
        $I->fillField(GlobalLocators::$loginPassInput, $password);
        $I->click(GlobalLocators::$loginButton);
        $I->waitForElementVisible(GlobalLocators::$headerText,  GlobalParams::LONG_WAIT);
    }

    /**
     * @param AcceptanceTester $I
     * @param $locator
     * @param int $timeout
     */
    protected function waitAndClickMouseOver(AcceptanceTester $I, $locator, $timeout = 30): void
    {
        $I->waitForElementVisible($locator, $timeout);
        $I->moveMouseOver($locator);
        $I->click($locator);
    }
    
    /**
     * @param AcceptanceTester $I
     * @param $locator
     * @param int $timeout
     */
    protected function waitAndClick(AcceptanceTester $I, $locator, $timeout = 30): void
    {
        $I->waitForElementVisible($locator, $timeout);
        $I->click($locator);
    }

    /**
     * @param AcceptanceTester $I
     * @param $locator
     * @param $data
     * @param int $timeout
     */
    protected function waitAndFillInput(AcceptanceTester $I, $locator, $data, $timeout = 30): void
    {
        $I->waitForElementVisible($locator, $timeout);
        $this->fillInput($I, $locator, $data);
    }

    /**
     * @param AcceptanceTester $I
     * @param $locator
     * @param $data
     */
    protected function fillInput(AcceptanceTester $I, $locator, $data): void
    {
        $I->fillField($locator, $data);
    }

    /**
     * Opens a record for edit
     *
     * @param AcceptanceTester $I
     * @param $textToSearchFor
     */
    protected function openRecordForEditInGrid(AcceptanceTester $I, $textToSearchFor): void
    {
        $list = $I->grabMultiple(GlobalLocators::GRID_ROW);

        foreach ($list as $record) {
            if (strpos($record, $textToSearchFor)) {
                $I->click(GlobalLocators::editButtonInGrid($textToSearchFor));
                return;
            }
        }
        $I->assertFalse('Record not found!');
    }

    /**
     * Clicks the delete button for a concrete record
     *
     * @param AcceptanceTester $I
     * @param $textToSearchFor
     */
    protected function clickDeleteButtonInGrid(AcceptanceTester $I, $textToSearchFor): void
    {
        $list = $I->grabMultiple(GlobalLocators::GRID_ROW);

        foreach ($list as $record) {
            if (strpos($record, $textToSearchFor)) {
                $I->click(GlobalLocators::deleteButtonInGrid($textToSearchFor));
                return;
            }
        }
        $I->assertFalse('Record not found!');
    }

    /**
     * Assertion for a record shown in grid
     *
     * @param AcceptanceTester $I
     * @param $textToSearchFor
     */
    protected function assertItemInGrid(AcceptanceTester $I, $textToSearchFor): void
    {
        $list = $I->grabMultiple(GlobalLocators::GRID_ROW);

        foreach ($list as $record) {
            if (strpos($record, $textToSearchFor)) {
                $I->assertTrue(true, 'The record is in the grid.');
                return;
            }
        }
        $I->assertFalse('Record not found!');
    }

    /**
     * Assertion that a record is not in grid
     *
     * @param AcceptanceTester $I
     * @param $textToSearchFor
     */
    protected function assertItemNotInGrid(AcceptanceTester $I, $textToSearchFor): void
    {
        $list = $I->grabMultiple(GlobalLocators::GRID_ROW);

        foreach ($list as $record) {
            if (strpos($record, $textToSearchFor)) {
                $I->assertFalse(true, 'The record is in the grid.');
                return;
            }
        }
        $I->assertTrue(true, 'Record not found!');
    }

    /**
     * Assertion that text is populated in field - NOT for free type text fields
     *
     * @param AcceptanceTester $I
     * @param $field
     * @param $text
     */
    protected function assertTextIsInField(AcceptanceTester $I, $field, $text): void
    {
        $textFromField = $I->grabTextFrom($field);
        $I->assertEquals($text, $textFromField);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $userType
     * @param string $module
     * @param string $subModule
     * @param string $subSubModule
     */
    protected function loginAndNavigate(AcceptanceTester $I, $userType, $module, $subModule, $subSubModule = null)
    {
        $this->login($I, $userType);
        $this->navigateToAdminModule($I, $module, $subModule, $subSubModule);
    }

    /**
     * Generates dynamic locators
     * @param string $locator
     * @param string @dynamicLocatorValue
     */
    protected static function generateLocator($locator, $dynamicLocatorValue)
    {
        return str_replace('$$', $dynamicLocatorValue, $locator);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $module
     * @param string $subModule
     * @param string $subSubModule
     */
    protected function navigateToAdminModule(AcceptanceTester $I, $module, $subModule = null, $subSubModule = null)
    {
        $I->click(['link' => $module]);
        $I->wait(GlobalParams::SHORT_WAIT);
        if ($subModule) {
            $I->click(['link' => $subModule]);
            $I->wait(GlobalParams::WAIT);
        }
        if ($subSubModule != null) {
            $I->click('//a[contains(@href, \'' . $subSubModule . '\')]');
            $I->wait(GlobalParams::SHORT_WAIT);
        }
    }

    /**
     * @param AcceptanceTester $I
     * @param string $user
     * @param array $path
     */
    protected function loginAndNavigateToNestedModule(AcceptanceTester $I, $user, array $path)
    {
        $this->login($I, $user);
        $this->navigateToNestedModule($I, $path);
    }

    /**
     * @param AcceptanceTester $I
     * @param array $path
     */
    protected function navigateToNestedModule(AcceptanceTester $I, array $path)
    {
        foreach ($path as $module) {
            $I->click(['link' => $module]);
            $I->wait(GlobalParams::SHORT_WAIT);
        }
    }

    /**
     * @param AcceptanceTester $I
     * @param string $name is the Breadcrumb name: OneSearch API Users, Tax Rules, etc
     */
    protected function useBreadcrumbs(AcceptanceTester $I, $name)
    {
        $I->click('//a[text()=\'' . $name . '\']');
        $I->wait(GlobalParams::SHORT_WAIT);
    }

    /**
     * @param AcceptanceTester $I
     */
    protected function adminLogout(AcceptanceTester $I)
    {
        $I->amGoingTo('logout');
        $I->waitForElementVisible('//div[contains(@class,\'dropdown-user\')]//div', GlobalParams::MID_WAIT);
        $I->wait(GlobalParams::MID_WAIT);
        $I->click('//div[contains(@class,\'dropdown-button__arrow\')]');
        $I->waitForElementVisible('//td[.=\'Sign Out\']', GlobalParams::MID_WAIT);
        $I->click('//td[.=\'Sign Out\']');
        $I->wait(GlobalParams::WAIT);
        $I->see('Sign in', '//p[text()=\'Sign in\']');
    }

    /**
     * @param AcceptanceTester $I
     * @param string $fieldToFilter is the label: Account/ API USER/ Username
     * @param string $value text to filter
     */
    protected function searchFilter(AcceptanceTester $I, $fieldToFilter, $value)
    {
        $locator = '//p[text()=\'' . $fieldToFilter . '\']/../../../../..//input';
        $I->fillField($locator, $value);
        $I->wait(GlobalParams::SHORT_WAIT);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $message mesage at header to verify
     */
    protected function verifyMessage(AcceptanceTester $I, $message)
    {
        $I->waitForElement('//*[text()=\'' . $message . '\']', GlobalParams::LONG_WAIT);
    }

        /**
     * @param AcceptanceTester $I
     * @param string $message mesage at header to verify
     */
    protected function verifyPartialMessage(AcceptanceTester $I, $message)
    {
        $I->waitForElement('//*[contains(text(), \'' . $message . '\')]', GlobalParams::LONG_WAIT);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $dropDownLocator
     * @param string $dropDownFieldLocator
     * @param string $value
     */
    protected function selectDropdownOption(AcceptanceTester $I, $dropDownLocator, $dropDownFieldLocator, $value, $wait = GlobalParams::WAIT)
    {
        $I->click($dropDownLocator);
        $I->wait($wait);
        $I->fillField($dropDownFieldLocator, $value);
        $I->wait($wait);
        $I->pressKey($dropDownFieldLocator, WebDriverKeys::ARROW_DOWN);
        $I->pressKey($dropDownFieldLocator, WebDriverKeys::ENTER);
        $I->wait($wait);
    }

    /**
     * Drop-down without search field
     * @param AcceptanceTester $I
     * @param $dropDownLocator
     * @param $dropDownFieldLocator
     * @param $list
     * @param $value
     */
    protected function filterDropdownOption(AcceptanceTester $I, $dropDownLocator, $dropDownFieldLocator, $list, $value)
    {
        $I->click($dropDownLocator);
        $I->fillField($dropDownFieldLocator, $value);
        $I->wait(GlobalParams::MICRO_WAIT);
        $I->pressKey($list, WebDriverKeys::ENTER);
        $I->wait(GlobalParams::MICRO_WAIT);
    }

    /**
     * @param AcceptanceTester $I
     * @param $dropDown
     * @param $field
     * @param $listOption
     * @param $value
     */
    protected function mouseOverAndSelectLocator(AcceptanceTester $I, $dropDown, $field, $listOption, $value): void
    {
        $I->moveMouseOver($dropDown);
        $this->clickAndWait($I, $dropDown, GlobalParams::WAIT);
        $I->fillField($field, $value);
        $I->wait(GlobalParams::SHORT_WAIT);
        $I->click($listOption);
        $I->wait(GlobalParams::MICRO_WAIT);
    }

    /**
     * @param AcceptanceTester $I
     * @param $dropDown
     * @param $field
     * @param $value
     */
    protected function mouseOverAndSelect(AcceptanceTester $I, $dropDown, $field, $value): void
    {
        $I->moveMouseOver($dropDown);
        $I->click($dropDown);
        $I->fillField($field, $value);
        $I->wait(GlobalParams::SHORT_WAIT);
        $I->click(str_replace('$$', $value, GlobalLocators::$divText));
        $I->wait(GlobalParams::MICRO_WAIT);
    }

    protected function setAccountValue(AcceptanceTester $I, $value): void
    {
        $I->moveMouseOver(GlobalLocators::CLEAR_VALUE);
        $I->click(GlobalLocators::CLEAR_VALUE);
        $I->click(GlobalLocators::ACCOUNT_DROPDOWN);
        $I->fillField(GlobalLocators::ACCOUNT_FIELD, $value);
        $I->wait(GlobalParams::SHORT_WAIT);
        $I->click(str_replace('$$', $value, GlobalLocators::$divText));
        $I->wait(GlobalParams::SHORT_WAIT);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $dropDownInput
     * @param string $value
     * @param int wait
     */
    protected function selectDropdownValue(AcceptanceTester $I, $dropDown, $value, $wait = null, $loc = 'div')
    {
        if ($loc === 'div') {
            $loc = '//div[contains(@class, \'' . $dropDown . '\')]//input';
        } else if ($loc === 'span') {
            $loc = '//span[text()= \'' . $dropDown . '\']/../input';
        }
        $I->fillField($loc, $value);
        if ($wait === null) {
            $wait = 1;
        }
        $I->wait($wait);
        $I->click('//div[contains(@class, \'list__item\') and text()=\''. $value .'\']');
        $I->wait(GlobalParams::SHORT_WAIT);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $dropDownLocator
     * @param string $dropDownFieldLocator
     * @param string $list
     * @param int wait
     */
    protected function filterDropdown(\AcceptanceTester $I, $dropDownLocator, $dropDownFieldLocator, $listItem, $wait = null)
    {
        $I->click($dropDownLocator);
        $I->fillField($dropDownFieldLocator, $listItem);
        if ($wait === null) {
            $wait = 1;
        }
        $I->wait($wait);
        $I->click(str_replace('$$', $listItem, '//div[contains(@class,\'listgroupitem\')]//*[text()=\'$$\']'));
        $I->wait(GlobalParams::SHORT_WAIT);
    }

    /**
     * @param string $name
     * @param string $action  view or edit or delete
     * @param string $value
     * @param boolean $span, true if $name text is in span element
     */
    protected function generateActionLocator($name, $action, $value = null, $span = true)
    {
        if ($value === null) {
            $locator = '//*[.=\'' . $name . '\']/../../../../..//*[contains(@class, \'' . $action . '\')]';
        } else {
            if ($span ===  true) {
                $locator  = '//*[.=\'' . $value . '\']/../../../..//*[.=\'' . $name . '\']/../../../..//*[contains(@class, \'' . $action . '\')]';
            } else {
                $locator  = '//*[.=\'' . $value . '\']/../../../..//*[text() =\'' . $name . '\']/../../../../..//*[contains(@class, \'' . $action . '\')]';
            }
        }
        return $locator;
    }

    /**
     * @param AcceptanceTester $I
     * @param string $locator
     * @param int $wait
     */
    protected function clickAndWait(AcceptanceTester $I, $locator, $wait = GlobalParams::WAIT)
    {
        $I->click($locator);
        $I->wait($wait);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $field
     * @param int $wait
     */
    protected function clickButtonAndWait(AcceptanceTester $I, $field, $wait = GlobalParams::WAIT, $loc = 'div')
    {
        if ($loc === 'div') {
            $this->clickAndWait($I, $this->generateLocator(GlobalLocators::$fieldLocatorDiv, $field), $wait);
        } else if ($loc === 'span') {
            $this->clickAndWait($I, '//span[text()= \'' . $field . '\']', $wait);
        }
    }

    /**
     * @param AcceptanceTester $I
     * @param string $locatorToClick
     * @param string $locatorToWait
     */
    protected function clickAndWaitForElementVisible(AcceptanceTester $I, $locatorToClick, $locatorToWait)
    {
        $I->click($locatorToClick);
        $I->waitForElementVisible($locatorToWait);
    }

    /**
     * @param AcceptanceTester $I
     */
    protected function clearFiltering(AcceptanceTester $I)
    {
        $I->click('(//div[contains(@class, \'settings\')])[1]');
        $this->clickAndWait($I, $this->generateLocator(GlobalLocators::$text, 'Clear All'));
    }

    /**
     * @param AcceptanceTester $I
     * @param string $field
     * @param string $value
     * @param int $wait
     */
    /**
     * @param AcceptanceTester $I
     * @param string $field
     * @param string $value
     * @param int $wait
     */
    protected function setValue(AcceptanceTester $I, $field, $value, $wait = GlobalParams::WAIT, $loc = 'div')
    {
        if ($loc === 'div') {
            $this->clickAndWait($I, $this->generateLocator(GlobalLocators::$fieldLocatorDiv, $field), $wait);
        } else if ($loc === 'span') {
            $this->clickAndWait($I, '//span[text()= \'' . $field . '\']', $wait);
        }
        $this->clickAndWait($I, str_replace('$$', $value, '//div[contains(@class,\'list\')]//*[text()=\'$$\']'), $wait);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $field
     * @param int $wait
     */
    protected function pressEnterAndWait(\AcceptanceTester $I, $field, $wait = GlobalParams::WAIT)
    {
        $I->pressKey($field, WebDriverKeys::ENTER);
        $I->wait($wait);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $field @div
     * @param string $value
     * @param int $wait
     */
    protected function fillFieldAndWait(\AcceptanceTester $I, $field, $value, $wait = GlobalParams::WAIT)
    {
        $I->fillField(str_replace('$$', $field, GlobalLocators::$input), $value);
        $I->wait($wait);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $field @placeholder
     * @param string $value
     * @param int $wait
     */
    protected function fillAndWait(\AcceptanceTester $I, $field, $value, $wait = GlobalParams::WAIT)
    {
        $I->fillField($this->generateLocator(GlobalLocators::$inputPlaceholder, $field), $value);
        $I->wait($wait); 
    }

    /**
     * @param AcceptanceTester $I
     * @param string $button
     * @param string $message
     */
    protected function clickAndVerifyMessage(AcceptanceTester $I, $button, $message, $wait = GlobalParams::SHORT_WAIT)
    {
        $this->clickAndWait($I, $button, $wait);
        $this->verifyMessage($I, $message);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $inputFieldLocator
     * @param string $value
     */
    protected function addTag(AcceptanceTester $I, $inputFieldLocator, $value, $wait = GlobalParams::MICRO_WAIT)
    {
        $I->fillField($inputFieldLocator, $value);
        $I->wait($wait);
        $I->pressKey($inputFieldLocator, WebDriverKeys::ENTER);
        $I->wait($wait);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $field
     */
    protected function webdriverDelete(AcceptanceTester $I, $field)
    {
        $I->pressKey($field, WebDriverKeys::CONTROL . 'a');
        $I->pressKey($field, WebDriverKeys::DELETE);
        $I->wait(GlobalParams::MICRO_WAIT);
    }
    
    /**
     * @param AcceptanceTester $I
     * @param array $expected
     */
    protected function grabAndAssert(\AcceptanceTester $I, $expected)
    {
        $list = $I->grabMultiple(GlobalLocators::LIST);
        $removedId = array_shift($list);
        $I->assertEquals($expected, $list);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $disabledField
     * @throws Exception
     */
    protected function verifyDisabled(\AcceptanceTester $I, $disabledField)
    {
        $disabled = $this->generateLocator(GlobalLocators::$inputContainsClass, $disabledField);

        try {
            $I->fillField($disabled, 'test');
        } catch (\Exception $e) {
            $I->comment($disabledField . ' field is disabled');
        }
    }

}
