<?php
namespace App\Constants;

class Frequency
{
    const DAY = 'Codziennie';
    const WEEK = 'Co tydzień';
    const MONTH = 'Co miesiąc';
    const QUARTER = 'Co kwartał';
    const YEAR = 'Co rok';
    const FREQUENCIES = [
        'day' => self::DAY,
        'week' => self::WEEK,
        'month' => self::MONTH,
        'quarter' => self::QUARTER,
        'year' => self::YEAR,
    ];
}
