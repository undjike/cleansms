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

        $this->assertTrue(
            (int) filter_var($result, FILTER_SANITIZE_NUMBER_INT) > -1
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
                "Hi girl, do you know who is thinking about you right now? Though \nIt is " . date('J d F Y H:i'),
                $to = ['+237697777205']
            );

        $this->assertTrue(
            count($to) == 1 ?
                filter_var($result, FILTER_SANITIZE_NUMBER_INT) == "1"
                : is_array($result)
        );
    }
}