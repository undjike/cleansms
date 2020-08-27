<?php

/*
 * SmsServiceTest.php
 *
 *  @author    Ulrich Pascal Ndjike Zoa <ndjikezoaulrich@gmail.com>
 *  @project    cleansms
 *
 *  Copyright 2020
 *  27/08/2020 11:27
 */

namespace Undjike\CleanSmsPhp\Tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use Undjike\CleanSmsPhp\CleanSms;

class SmsServiceTest extends TestCase
{
    const SMS_EMAIL = 'ndjikezoaulrich@gmail.com';
    const SMS_API_KEY = 'Your CleanSMS API Key here';

    /**
     * Test SMS account balance
     *
     * @throws Exception
     */
    public function testGetCredit()
    {
        $result = CleanSms::create()
            ->apiKey(self::SMS_API_KEY)
            ->email(self::SMS_EMAIL)
            ->getCredit();

        $jsonable = json_decode($result, true);

        if (json_last_error() === JSON_ERROR_NONE)
            $this->assertTrue(false, $jsonable['result']);
        else
            $this->assertTrue(
                (int) $result > -1
            );
    }

    /**
     * @throws Exception
     */
    public function testSendSms()
    {
        $result = CleanSms::create()
            ->apiKey(self::SMS_API_KEY)
            ->email(self::SMS_EMAIL)
            ->sendSms(
                'Hi man, are you okay this morning?',
                '+237656278151'
            );

        $jsonable = json_decode($result, true);

        if (json_last_error() === JSON_ERROR_NONE)
            $this->assertTrue(false, $jsonable['result']);
        else
            $this->assertTrue(
                (int) $result === 1
            );
    }
}