<?php
/**
 * Copyright (c) 2019-2020 by PROS, Inc.  All Rights Reserved.
 * This software is the confidential and proprietary information of
 * PROS, Inc. ("Confidential Information").
 * You may not disclose such Confidential Information, and may only
 * use such Confidential Information in accordance with the terms of
 * the license agreement you entered into with PROS.
 */

namespace Locators;

/**
 * Class GlobalLocators
 * @package Locators
 */
class GlobalLocators
{
    public static $text = "//*[text()='$$']";
    public static $containsText = "//*[contains(text(),'$$')]";
    public static $containsClass = "//*[contains(@class, '$$')]";
    public static $pText = "//p[text()='$$']";
    public static $pTextIndex = "(//p[text()='$$'])[##]";
    public static $divText = "//div[text()='$$']";
    public static $h2Text = "//h2[text()='$$']";
    public static $h3Text = "//h3[text()='$$']";
    public static $tdText = "//td[text()='$$']";
    public static $fieldLocatorDiv = "//div[contains(@class, '$$')]";
    public static $inputPlaceholder = "//input[@placeholder = '$$']";
    public static $textareaPlaceholder = "//textarea[@placeholder = '$$']";
    public static $textarea = "//textarea[contains(@class, '$$')]";
    public static $spanTextLocator = "//span[text()='$$']";
    public static $inputContainsClass = "//input[contains(@class, '$$')]";
    public static $disabled = "//input[contains(@value, '$$') and @disabled]";
    public static $input = "//div[contains(@class, '$$')]/input";
    public static $inputValue = "//input[contains(@value, '$$')]";
    public static $divClass = "//div[@class = '$$']";
    public static $classLocator = "//*[contains(@class, '$$')]";
    public static $inputLocator = "//*[text()='$$']/../../../..//input";
    public static $inputField = "//div[contains(@class, '$$')]//input";
    public static $clearButton = "//div[contains(@class, '$$')]//div[@class='clear']";
    public static $listedValue = "//div[contains(@class, 'listgroupitem')]//p[text()='$$']";
    public static $link =  "//a[contains(@href, '$$')]";
    public static $breadcrumbs = "//ul[@class='breadcrumbs']//a[contains(@href, '$$')]";
    public static $clear = "//div[contains(@class, '$$')]//div[contains(@class,'clear')]";

    /* Login Locators */
    public static $loginUserInput = "//input[@placeholder='Username']";
    public static $loginPassInput = "//input[@placeholder='Password']";
    public static $loginButton = "//div[@class='login-form-button']//p";

    /* Header Locators */
    public static $headerText = "//span[contains(text(), 'Administrative Interface')]";
    public const HEADER_NEW_BUTTON = "//p[text()='New']";
    public const HEADER_SAVE_BUTTON = "//div[text()='Save']";

    /* Menu Locators */
    public static $menuDashboard = ['link' => 'Dashboard'];
    public static $menuCoreSearch = ['link' => 'Core Search System'];
    public static $menuDynamicPricing = ['link' => 'Dynamic Pricing'];
    public static $menuCustomRegions = ['link' => 'Custom Regions'];
    public static $menuMerchandaising = ['link' => 'Merchandising System'];
    public static $menuServices = ['link' => 'Services'];
    public static $menuRichContent = ['link' => 'Rich Content'];
    public static $menuUserManagment = ['link' => 'User Management'];
    public static $menuAccounts = ['link' => 'Accounts'];
    public static $menuLoginUsers = ['link' => 'Login Users'];
    public static $menuApiUsers = ['link' => 'API Users'];
    public static $menuFSApiUsers = ['link' => 'FastSearch API Users'];
    public static $menuOSApiUsers = ['link' => 'OneSearch API Users'];
    public static $menuPrecomputed = ['link' => 'Precomputed System'];
    public static $menuCacheEnvironments = ['link' => 'Cache Environments'];
    public static $menuRepricer = ['link' => 'Repricer'];
    public static $menuTaxRules = ['link' => 'Tax Rules'];
    public static $menuWaiverRules = ['link' => 'Waiver Rules'];
    public static $menuSeatAvailability = ['link' => 'Seat Availability'];
    public static $menuAVLExpirations = ['link' => 'Availability Expirations'];
    public static $menuAnalytics = ['link' => 'Analytics'];
    public static $menuSalesConsole = ['link' => 'Sales Console'];
    public static $menuInternalSystem = ['link' => 'Internal System'];
    public static $menuConfiguration = ['link' => 'Configuration'];
    public static $menuCustomParameters = ['link' => 'Custom Parameters'];
    public static $menuCustomSubCodes = ['link' => 'Custom Sub-Codes'];
    public static $menuCoreSearchSystem = ['link' => 'Core Search System'];
    public static $menuSignificantSegment = ['link' => 'Significant Segment Override'];
    public static $menuSellersDropDown = ['link' => 'Sellers'];
    public static $menuSellers = '//span[.=\'Sellers\']/../../*/following-sibling::ul//span[.=\'Sellers\']';
    public static $menuUserSellerPairs = ['link' => 'User/Seller pairs'];
    public static $menuFareOwners = ['link' => 'Fare Owners'];
    public static $menuFareBuckets = ['link' => 'Fare Buckets'];
    public static $menuBuckets = ['link' => 'Buckets'];
    public static $menuMarkets = ['link' => 'Markets'];
    public static $menuMarketBuckets = ['link' => 'Market Buckets'];
    public static $menuSalesOfferEngine = ['link' => 'Sales Offer Engine'];
    public static $menuAdministrativeSettings = ['link' => 'Administrative Settings'];
    public static $menuSsrConfiguration = ['link' => 'SSR Configuration'];
    public static $menuResultControl = ['link' => 'Result Control'];
    public static $menuPriceRules = ['link' => 'Price Rules'];
    public static $menuFareTypes = ['link' => 'Fare Types'];
    public static $menuRCServices = "(//span[text()='Services'])[2]";
    public static $menuRCBanners = ['link' => 'Banners'];
    public static $menu = ['link' => '$$'];

    public const OK_BUTTON = "//p[text()='OK']";
    public const ADD_BUTTON = "//p[text()='Add']";
    public const COPY_CONFIRM_BUTTON = "//p[text()='Copy']";

    public const CONFIRM_APPLY = "//a[contains(@class, 'apply-confirmation')]";

    public const IMPORT = "//div[contains(@class, 'confirm')]//p[text()='Import']";
    public const IMPORT_BEHAVIOUR = "//p[contains(@class, 'dropdown')][text()='Import behaviour']";

    /* Delete PopUp */
    public const DELETE = "//div[contains(@class, 'confirm' )]//p[text()= 'Delete']";
    public const TITLE_DELETE_ITEM = "//div[text()='Delete Item']";
    public static $cancelButton = "//p[text()='Cancel']";
    public static $usernameDropdown = "//div[contains(@class,'dropdown-user')]//div";
    public static $profile = "//td[text()='Profile']";

    /* Grid */
    public const GRID_ROW = "//div[contains(@class, 'zippy-react-datagrid__row zippy-react-datagrid__row')]";
    public static $sortButton = "//div[contains(@class, 'sort')]//p[text() = '$$']";
    public const EDIT_BUTTON = "//*[contains(@class, 'button-edit')]";
    public const COPY_BUTTON = "//*[contains(@class, 'button-copy')]";
    public const DELETE_BUTTON = "//div[contains(@class, 'button-delete')]";
    public const VIEW_BUTTON = "//*[contains(@class, 'button-view')]";
    public const LIST = "//div[contains(@class, 'datagrid__row')]/child::*/child::div[contains(@class, 'datagrid-cell')]";
    public const IDS = "//div[contains(@class, 'active-row')]//div[contains(@data-for, 'id')]//p";
    public const REQUIRED_FIELD_ERR = "//div[contains(@class, 'control-error')]";
    public const CHOOSE_FILE_TO_IMPORT = "//input[@type = 'file']";
    public static $position = "[position()<$$]";

    /* Merchandising Account filter */
    public const CLEAR_VALUE = "//div[contains(@class,'combo-box__clear-icon')]";
    public const ACCOUNT_DROPDOWN = "//div[contains(@class,'input-accounts')]";
    public const ACCOUNT_FIELD = "//div[contains(@class,'accounts')]/..//input[contains(@class,'combo-box__input')]";

    /* User Management */
    public static $disabledField = "//div[contains(@class,'$$') and contains(@class,'disabled')]/input";

    public const BANNER_ERROR = "//div[contains(@class, 'banner type-error')]//span/following-sibling::span";
    public static $fieldLocator = "//div[contains(@class, 'card')]//div[contains(@class, '$$')]//input";
    /**
     * @param int $column
     * @return string
     */
    public static function sortButtonInGrid($column): string
    {
        return '(//*[contains(@class, \'zippy-react-datagrid__column-header__content\')])[' . $column . ']';
    }

    /**
     * @param string $textToSearchFor
     * @return string
     */
    public static function editButtonInGrid($textToSearchFor): string
    {
        return '//*[contains(text(), \'' . $textToSearchFor . '\')]/../../../..//a[contains(@class,\'adminui-button-edit\')]';
    }

    /**
     * @param string $textToSearchFor
     * @return string
     */
    public static function deleteButtonInGrid($textToSearchFor): string
    {
        return '//*[contains(text(), \'' . $textToSearchFor . '\')]/../../../..//div[contains(@class,\'adminui-button-delete\')]';
    }

    /* Merchandising */

    public const CLEAR_NAME_FILTER = "//input[@placeholder= 'Search']/..//div[@class='clear']";
    public const MER_LIST = "//div[contains(@class, 'datagrid__row')]//*[text()]";
    public const TEXTAREA = "//*[contains(@class, 'input-textarea')]";
    public const ATPCO_RADIO = "//p[text()='ATPCO']/../..//div[@role = 'radio']";

    public static $radioButton = "//p[text()='$$']/../..//div[@role= 'radio']";
    public static $checkbox = "//div[@role = 'checkbox'][@aria-label = '$$']";
    public static $disabledFieldMer = "//*[contains(@class, '$$')]['disabled']";
    public static $merInput = "//p[text()='$$']/../../..//input";
}
