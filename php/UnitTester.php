<?php
/**
 * Copyright (c) 2019 by PROS, Inc.  All Rights Reserved.
 * This software is the confidential and proprietary information of
 * PROS, Inc. ("Confidential Information").
 * You may not disclose such Confidential Information, and may only
 * use such Confidential Information in accordance with the terms of
 * the license agreement you entered into with PROS.
 */

use Vayant\Models\BaseModel;

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
class UnitTester extends \Codeception\Actor
{

    use _generated\UnitTesterActions;

    /**
     * Define custom actions here
     */
    /**
     * @param BaseModel $value
     * @param array $array
     * @return bool
     */
    public function assertModelInArray($value, $array)
    {
        $valClass = get_class($value);
        foreach ($array as $item) {
            if (get_class($item) === $valClass && $item->id() === $value->id()) {
                return true;
            }
        }

        $failureDescription = sprintf('Failed asserting that %s is in collection', $value);
        throw new PHPUnit_Framework_ExpectationFailedException(
            $failureDescription, null
        );
    }
}
