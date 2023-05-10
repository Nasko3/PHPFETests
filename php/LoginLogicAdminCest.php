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
use Locators\LoginLogicLocators;
use Params\UserManagementParams;
use Properties\UserManagementFunctions;

class LoginLogicAdminCest extends AcceptanceCest
{
    use UserManagementFunctions;

    private const PASS = 'Testweb20@';
    private const NEW_PASS = 'Newp@ssword123!';
    private const TEST_USER = 'testPasswordUser@vayant.com';
    private const USER = 'autoWebUser@vayant.com';
    private const LOCKED_MSG ='Your account is locked!';
    private const ERROR_MSG = 'Incorrect username or password!';

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6965
     */
    public function changeForgottenPassword(AcceptanceTester $I)
    {
        $I->amGoingTo('Change forgotten password');
        $I->amOnPage('/');
        $getUrl = substr($I->getCurrentUrl(), 0, -8);
        $I->comment($getUrl);
        $I->amOnUrl($getUrl . '/public/v5/user/forgotten-password/c761567635b6e20604aa94e01fe710c8fa93dd8b09ce192e3cd04286c1b88c38');
        $I->wait(GlobalParams::WAIT);
        $I->fillField(LoginLogicLocators::NEW_PASS, self::NEW_PASS);
        $I->wait(GlobalParams::SHORT_WAIT);
        $I->fillField(LoginLogicLocators::CONFIRM_NEW_PASS, self::NEW_PASS);
        $this->clickAndWait($I, LoginLogicLocators::SAVE_NEW_PASS);
        $this->assertElementPresent($I, 'Successfully changed password. Please Sign in.');
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6964
     */
    public function sendEmailForgottenPassword(AcceptanceTester $I)
    {
        $I->amGoingTo('Send forgotten password email');
        $I->amOnPage('/v5/logout');
        $I->wait(GlobalParams::MICRO_WAIT);
        $this->clickAndWait($I, LoginLogicLocators::CANT_ACCESS_MSG);
        $I->fillField(LoginLogicLocators::EMAIL_FIELD, self::TEST_USER);
        $this->clickAndWait($I, LoginLogicLocators::SEND_BUTTON);
        $this->assertElementPresent($I, 'If such user exists, email with instructions will be send.');
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6966
     */
    public function loginAfterChangeForgottenPassword(AcceptanceTester $I)
    {
        $I->amGoingTo('Log-in after change of forgotten password');
        $this->testLogin($I, self::TEST_USER, self::NEW_PASS);
        $this->assertUserLoggedIn($I, self::TEST_USER, GlobalParams::ACCOUNT);
        $this->adminLogout($I);
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6816
     */
    public function verifyEmailHistory(AcceptanceTester $I)
    {
        $I->amGoingTo('Log-in after change of forgotten password');
        $this->loginAndNavigate($I, 'ManagerWeb', GlobalParams::INTERNAL_SYS, 'Email History');
        $I->seeElement($this->generateLocator(GlobalLocators::$pText, self::TEST_USER));
        $I->seeElement($this->generateLocator(GlobalLocators::$pText, 'forgottenPassword'));
        $this->adminLogout($I);
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6967
     */
    public function activateUser(AcceptanceTester $I)
    {
        $I->amGoingTo('Activate created in WebAdmin user');
        $I->amOnPage('/');
        $getUrl = substr($I->getCurrentUrl(), 0, -8);
        $I->comment($getUrl);
        $I->amOnUrl($getUrl . '/public/v5/user/activate/ab80eccdfb1761fed11941362b1309ef30274202b86708c3544f7ebb9bd59c26');
        $I->wait(GlobalParams::WAIT_THREE);
        $I->waitForElement($this->generateLocator(GlobalLocators::$pText, 'Save'));
        $this->fillAndWait($I, 'Password', self::NEW_PASS, GlobalParams::SHORT_WAIT);
        $this->fillAndWait($I, 'Confirm password', self::NEW_PASS, GlobalParams::SHORT_WAIT);
        $this->clickAndWait($I, LoginLogicLocators::SAVE_NEW_PASS);
        $this->assertElementPresent($I, 'Successfully created password. Please Sign in.');
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6968
     */
    public function loginAfterActivateUser(AcceptanceTester $I)
    {
        $user = 'disabledUser@vayant.com';
        $I->amGoingTo('Log-in after activation of created user');
        $this->testLogin($I, $user, self::NEW_PASS);
        $this->assertUserLoggedIn($I, $user, GlobalParams::ACCOUNT);
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6959
     */
    public function loginWithWrongUsername(AcceptanceTester $I)
    {
        $I->amGoingTo('Log-in with invalid Username');
        $I->amOnPage('/v5/logout');
        $I->waitForElementVisible(GlobalLocators::$loginUserInput, GlobalParams::LONG_WAIT);
        $I->fillField(GlobalLocators::$loginUserInput, 'test@mail.com');
        $this->waitAndClick($I, GlobalLocators::$loginButton);
        $I->waitForElement(
            $this->generateLocator(GlobalLocators::$spanTextLocator, 'Login user does not exist!')
        );
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6960
     */
    public function loginWithWrongPassword(AcceptanceTester $I)
    {
        $I->amGoingTo('Log-in with wrong Password');
        $this->testLogin($I, UserManagementParams::PRECOMPUTED_USER, 'Password123@');
        $I->waitForElement(
            $this->generateLocator(GlobalLocators::$containsText, self::ERROR_MSG)
        );
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6961
     */
    public function setNewPasswordInProfile(AcceptanceTester $I)
    {
        $I->amGoingTo('Set Grace Password using Profile Module');
        $this->login($I, 'ManagerTest');
        $I->wait(GlobalParams::WAIT);
        $this->goToProfilePassTab($I);
        $this->setPassword($I, UserManagementParams::PASS, true);
        $this->verifyMessage($I, UserManagementParams::PASS_MSG);
        $this->adminLogout($I);
        //Login with the new password
        $I->amGoingTo("login with grace password");
        $this->testLogin($I, self::USER, UserManagementParams::PASS);
        $this->assertUserLoggedIn($I, self::USER, GlobalParams::ACCOUNT);
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6970
     */
    public function lockReadPermissionsUser(AcceptanceTester $I)
    {
        $user = 'repricerRead@vayant.com';
        $I->amGoingTo('Lock user after 6 attempts to log in');
        for ($attempt = 1; $attempt < 7; $attempt++) {
            $this->testLogin($I, $user, UserManagementParams::PASS);
            $I->waitForElement(
                $this->generateLocator(GlobalLocators::$containsText, self::ERROR_MSG)
            );
        }
        $this->testLogin($I, $user, self::PASS);
        $I->waitForElement(
            $this->generateLocator(GlobalLocators::$containsText, self::LOCKED_MSG)
        );
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6971
     */
    public function lockUserFromWebAdmin(AcceptanceTester $I)
    {
        $I->amGoingTo('Lock user with the Lock button');
        $this->loginAndNavigate($I, 'ManagerWeb', GlobalParams::USER_MANAGEMENT, GlobalParams::WEB_USERS);
        $this->searchFilter($I, GlobalParams::USERNAME_FIELD, UserManagementParams::PRECOMPUTED_USER);
        $loc = $this->generateActionLocator(UserManagementParams::PRECOMPUTED_USER, UserManagementParams::EDIT, UserManagementParams::COMPANY);
        $this->clickAndWait($I, $loc);
        $I->click(LoginLogicLocators::LOCK_BUTTON);
        $I->dontSee(LoginLogicLocators::LOCK_BUTTON);
        $I->click(GlobalLocators::HEADER_SAVE_BUTTON);
        $this->verifyMessage($I, UserManagementParams::SUCCESS_MSG);
        // log-in of locked user
        $this->testLogin($I, UserManagementParams::PRECOMPUTED_USER, self::PASS);
        $I->waitForElement(
            $this->generateLocator(GlobalLocators::$containsText, self::LOCKED_MSG)
        );
    }

    /**
     * @group CodeCoverage
     * @group LoginLogicAdmin
     * @JiraTC_WEB-6969
     */
    public function lockAdminUser(AcceptanceTester $I)
    {
        $I->amGoingTo('Lock user after 3 attempts to log in');
        for ($attempt = 1; $attempt < 4; $attempt++) {
            $this->testLogin($I, UserManagementParams::MANAGER, self::NEW_PASS);
            $I->waitForElement(
                $this->generateLocator(GlobalLocators::$containsText, self::ERROR_MSG)
            );
        }
        $this->testLogin($I, UserManagementParams::MANAGER, self::PASS);
        $I->waitForElement(
            $this->generateLocator(GlobalLocators::$containsText, self::LOCKED_MSG)
        );
    }

    #region Helper Methods

    /**
     * @param AcceptanceTester $I
     * @param string $user is the  login username
     * @param string $pass is the password 
     */
    protected function testLogin(AcceptanceTester $I, $user, $pass)
    {
        $I->amOnPage('/v5/logout');
        $I->amGoingTo('login with username ' . $user);
        $I->waitForElementVisible(GlobalLocators::$loginUserInput, GlobalParams::LONG_WAIT);
        $I->fillField(GlobalLocators::$loginUserInput, $user);
        $this->waitAndClick($I, GlobalLocators::$loginButton);
        $I->waitForElement(GlobalLocators::$loginPassInput, GlobalParams::LONG_WAIT);
        $I->fillField(GlobalLocators::$loginPassInput, $pass);
        $I->click(GlobalLocators::$loginButton);
    }

    /**
     * @param AcceptanceTester $I
     * @param string $username, @param string $account
     */
    protected function assertUserLoggedIn(AcceptanceTester $I, $username, $account)
    {
        $I->seeElement('//span[contains(text(),\'' . $username . ', ' . $account . '\')]');
    }

    /**
     * Navigate to Profile-> Password Management
     * @param AcceptanceTester $I
     */
    protected function goToProfilePassTab(AcceptanceTester $I)
    {
        $I->click(GlobalLocators::$usernameDropdown);
        $I->wait(GlobalParams::SHORT_WAIT);
        $I->click(GlobalLocators::$profile);
        $this->goToUserManagementTab($I, UserManagementParams::PASSWORDS_MODULE);
    }

    #endregion Helper Methods
}
