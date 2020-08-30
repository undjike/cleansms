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
    const SMS_API_KEY = '121|Nm51Tcy1596796895riAYPUp';

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

        $this->assertIsNumeric($result);
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
                "I can assure you, my little girl, that I do love you and I can't see any future without you. May God help me to keep you close as days, months, years and decades go by...",
                $to = ['+237659026491']
            );

        $this->assertTrue($result);
    }
}