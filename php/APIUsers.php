<?php
/**
 * Copyright (c) 2019 by PROS, Inc.  All Rights Reserved.
 * This software is the confidential and proprietary information of
 * PROS, Inc. ("Confidential Information").
 * You may not disclose such Confidential Information, and may only
 * use such Confidential Information in accordance with the terms of
 * the license agreement you entered into with PROS.
 */

namespace Models;

use \Generators\AbstractGenerator;

/**
 * Class APIUsers
 * @package Models
 * @author santov
 */
class APIUsers extends AbstractGenerator
{
    const ACCOUNT_ID = 'account_id';
    const USERNAME = 'username';
    const CUSTOMER_NAME = 'customer_name';
    const STATUS_ID = 'status_id';
    const PRODUCTS = 'products';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DESCRIPTION = 'description';
    const PASSWORDS = 'passwords';

    public function __construct(array $settings = [], $request = true, $value = true)
    {
        if ($request == true) {
            if ($settings !== []) {
                $this->setParam('userSettings', $settings);
            }
        } else {
            $this->setParam('success', $value);
            $this->setParam('data', $settings);
        }
    }

    /**
     * @param unknown $id
     */
    public function setID($id)
    {
        $accountSettings = $this->request['userSettings'] ?? [];
        $accountSettings['id'] = $id;
        $this->setParam('userSettings', $accountSettings);
    }

    /**
     *
     * @param unknown $accId
     */
    public function setAccountId($accId = null)
    {
        $userSettings = $this->request['userSettings'] ?? [];
        if ($accid !== null) {
            $this->$userSettings['account_id'] = $accId;
        } else {
            $this->$userSettings['account_id'] = '';
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param unknown $username
     */
    public function setUsername($username = null)
    {
        $userSettings = $this->request['userSettings'] ?? [];

        if ($username !== null) {
            $userSettings['username'] = $username;
        } else {
            $userSettings['username'] = '';
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param unknown $customerName
     */
    public function setCustomerName($customerName = null)
    {
        $userSettings = $this->request['userSettings'] ?? [];

        if ($customerName !== null) {
            $userSettings['customer_name'] = $customerName;
        } else {
            $userSettings['customer_name'] = '';
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param unknown $statusId
     */
    public function setStatusId($statusId = null)
    {
        $userSettings = $this->request['userSettings'] ?? [];

        if ($statusId !== null) {
            $userSettings['status_id'] = $statusId;
        } else {
            $userSettings['status_id'] = '';
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param array $products
     */
    public function setProducts(array $products = [])
    {
        $userSettings = $this->request['userSettings'] ?? [];

        if ($products !== []) {
            $userSettings['products'] = $products;
        } else {
            $userSettings['products'] = null;
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param unknown $date
     */
    public function setCreatedAt($date = null)
    {
        $userSettings = $this->request['userSettings'] ?? [];

        if ($date === null) {
            $userSettings['created_at'] = 'null';
        } else {
            $userSettings['created_at'] = $date;
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param unknown $date
     */
    public function setUpdatedAt($date = null)
    {
        $userSettings = $this->request['userSettings'] ?? [];

        if ($date == null) {
            $userSettings['updated_at'] = '';
        } else {
            $userSettings['updated_at'] = $date;
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param array $passwords
     */
    public function setPasswords(array $passwords = [])
    {
        $userSettings = $this->request['userSettings'] ?? [];

        if ($passwords === []) {
            $this->setParam('passwords', []);
        } else {
            $this->setParam('passwords', $passwords);
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param array $searchFeatures
     */
    public function setSearchFeatures(array $searchFeatures = [])
    {
        $userSettings = $this->request['userSettings'] ?? [];

        if ($searchFeatures === []) {
            $this->setParam('searchFeatures', []);
        } else {
            $this->setParam('searchFeatures', $searchFeatures);
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param array $userCfg
     */
    public function setUserCfg(array $userCfg = [])
    {
        $userSettings = $this->request['userSettings'] ?? [];
        if ($userCfg === []) {
            $this->setParam('userCfg', []);
        } else {
            $this->setParam('userCfg', $userCfg);
        }
        $this->setParam('userSettings', $userSettings);
    }

    /**
     *
     * @param array $array
     * @param unknown $value
     * @return unknown
     */
    public function setNestedId(array $array, $value)
    {
        $array['id'] = $value;
        return $array;
    }

    /**
     *
     * @param array $repricerCfg
     */
    public function setRepricerCfg(array $repricerCfg = [])
    {
        if ($repricerCfg === []) {
            $this->setParam('repricerCfg', []);
        } else {
            $this->setParam('repricerCfg', $repricerCfg);
        }
    }
}
