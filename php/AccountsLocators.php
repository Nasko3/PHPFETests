<?php
/**
 * Copyright (c) 2020 by PROS, Inc.  All Rights Reserved.
 * This software is the confidential and proprietary information of
 * PROS, Inc. ("Confidential Information").
 * You may not disclose such Confidential Information, and may only
 * use such Confidential Information in accordance with the terms of
 * the license agreement you entered into with PROS.
 */

namespace Locators;

/**
 * Class AccountsLocators
 * @package Locators
 */
class AccountsLocators
{
    // ==== Account Configuration ====
    public const ACTION_BUTTON_EDIT = "(//div[contains(@class,'pc-button-icon')])[2]";
    public const PRODUCTS_FIELD = "//div[contains(@class, 'input-products')]";
    public const PRODUCTS_FIELD_INPUT =  "//div[contains(@class, 'input-products')]//input";
    public const CLIENT_ACCOUNTS = "//div[contains(@class, 'client-accounts')]";
    public const CLIENT_ACCOUNTS_INPUT = "//div[contains(@class, 'client-accounts')]//input";
    public const DEMO_RADIOBUTTON = "//p[text()='Demo']/../..//div[contains(@class, 'is_demo')]";
    public const DEMO_CHECKED ="//p[text()='Demo']/../..//div[contains(@class, 'is_demo') and contains(@aria-checked, 'true')]";

    // ==== View  ====
    public const ACCOUNT_FIELD_DISABLED = "//div[contains(@class,'account') and contains(@class,'disabled')]/input";
    // ==== Reports and Statistics ====
    public const ALL_PRODUCTS_CHECKBOX = "//div[.='All Products']//div[@class='pc-checkbox-box']";
    public const ALL_PRODUCTS_CHECKED = "//div[@class='pc-checkbox-box checked']";
}
