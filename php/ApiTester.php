<?php
/**
 * Copyright (c) 2019 by PROS, Inc.  All Rights Reserved.
 * This software is the confidential and proprietary information of
 * PROS, Inc. ("Confidential Information").
 * You may not disclose such Confidential Information, and may only
 * use such Confidential Information in accordance with the terms of
 * the license agreement you entered into with PROS.
 */

use Codeception\Util\HttpCode;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class ApiTester extends \Codeception\Actor
{
    use _generated\ApiTesterActions;

    /**
     * Define custom actions here
     */

    /**
     * Adds common request headers
     * which WebAdmin API is expecting
     */
    public function addCommonWebRequestHeaders(): void
    {
        $this->haveHttpHeader('X-Requested-With', 'XMLHttpRequest');
        $this->haveHttpHeader('Content-type', 'application/json');
    }

    /**
     * Do common check for successful JSON response
     *
     * @param int $statusCode
     * @throws \Codeception\Exception\ModuleException
     */
    public function seeJsonResponseIsSuccessful($statusCode = HttpCode::OK)
    {
        $this->seeResponseCodeIs($statusCode);
        $this->seeResponseIsJson();
        $this->seeJsonResponseIsSuccess();
    }

    /**
     * Do common check for NOT successful JSON response
     *
     * @param int $statusCode
     * @throws \Codeception\Exception\ModuleException
     */
    public function seeJsonResponseIsNotSuccessful($statusCode = HttpCode::BAD_REQUEST)
    {
        $this->seeResponseCodeIs($statusCode);
        $this->seeResponseIsJson();
        $this->seeJsonResponseIsNotSuccess();
    }

    /**
     * Check for proper structure of Listing API endpoint (NEW structure of WebAdmin API JSON response)
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function seeListingJsonResponseHasCorrectStructure()
    {
        $expected = true;
        $response = $this->grabResponse();

        if ($response) {
            $response = json_decode($response, true);
        }

        $this->assertSame($expected, isset($response['success']), 'Response contains "success" element');
        $this->assertSame($expected, isset($response['data']), 'Response contains "data" element');
        $this->assertSame($expected, isset($response['data']['results']), 'Response data contains "results" element');
        $this->assertSame($expected, isset($response['data']['metadata']), 'Response data contains "metadata" element');
        $this->assertSame($expected, isset($response['data']['metadata']['pageSize']),
            'Response metadata contains "pageSize" element');
        $this->assertSame($expected, isset($response['data']['metadata']['totalEntries']),
            'Response metadata contains "totalEntries" element');
        $this->assertSame($expected, isset($response['data']['metadata']['totalPages']),
            'Response metadata contains "totalPages" element');
        $this->assertSame($expected, !isset($response['error']), 'Response does NOT contain error element');

        $this->assertSame($expected, is_array($response['data']), 'Response "data" element is array');
    }

    /**
     * Check for success: true in API response (NEW structure of WebAdmin API JSON response)
     *
     * @throws \Codeception\Exception\ModuleException
     */
    private function seeJsonResponseIsSuccess()
    {
        $response = $this->grabResponse();
        $response = json_decode($response, true);

        $this->assertTrue(isset($response['success']), 'Response contains "success" element');
        $this->assertTrue($response['success'], 'Response "success" element is true');
    }

    /**
     * Check for success: true in API response (NEW structure of WebAdmin API JSON response)
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function seeJsonResponseIsNotSuccess()
    {
        $response = $this->grabResponse();

        $response = json_decode($response, true);

        $this->assertTrue(isset($response['success']), 'Response contains "success" element');
        $this->assertFalse($response['success'], 'Response "success" element is false');
    }

    /**
     * Check for success: true in API response (NEW structure of WebAdmin API JSON response)
     *
     * @throws \Codeception\Exception\ModuleException
     */
    public function seeResponseIsError()
    {
        $response = $this->grabResponse();
        $response = json_decode($response, true);

        $this->assertFalse($response['success'], 'Response "success" element is false');
        $this->assertTrue(isset($response['error']), 'Response contains "error" element');
        $this->assertTrue(isset($response['error']['code']), 'Response error contains "code" element');
        $this->assertTrue(isset($response['error']['message']), 'Response error contains "message" element');
    }
}
