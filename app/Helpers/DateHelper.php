<?php


namespace App\Helpers;


use Carbon\Carbon;

class DateHelper
{

    public const DATE_THIS_WEEK = 1004;
    public const DATE_THIS_MOUTH = 1005;
    public const DATE_THIS_QUARTER = 1006;
    public const Date_this_year = 1007;

    public const DATE_LAST_WEEK = 1008;
    public const DATE_LAST_MONTH = 1009;
    public const DATE_LAST_QUARTER = 1010;
    public const DATE_LAST_YEAR = 1011;
    public const DATE_LAST_THREE_MOUTHS = 1012;
    public const DATE_LAST_THREE_YEARS = 1013;

    public const DATE_PASSED_THREE_DAYS = 1001;
    public const DATE_PASSED_SEVEN_DAYS = 1002;
    public const DATE_PASSED_THIRTY_DAYS = 1003;

    public const DATE_LAST_WEEK_TO_TODAY = 1014;
    public const DATE_LAST_MONTH_TO_TODAY = 1015;
    public const DATE_LAST_QUARTER_TO_TODAY = 1016;
    public const DATE_LAST_YEAR_TO_TODAY = 1017;


    public static function dates(int $type): ?array
    {
        $date = null;
        switch ($type) {
            case self::DATE_THIS_WEEK:
                $date = [
                    Carbon::now()->startOfWeek()->toDateTimeString(),
                    Carbon::now()->endOfWeek()->toDateTimeString(),
                ];
                break;
            case self::DATE_THIS_MOUTH:
                $date = [
                    Carbon::now()->startOfMonth()->toDateTimeString(),
                    Carbon::now()->endOfMonth()->toDateTimeString(),
                ];
                break;
            case self::DATE_THIS_QUARTER:
                $date = [
                    Carbon::now()->startOfQuarter()->toDateTimeString(),
                    Carbon::now()->endOfQuarter()->toDateTimeString(),
                ];
                break;
            case self::Date_this_year:
                $date = [
                    Carbon::now()->startOfYear()->toDateTimeString(),
                    Carbon::now()->endOfYear()->toDateTimeString(),
                ];
                break;

            case self::DATE_LAST_WEEK:
                $date = [
                    Carbon::now()->startOfWeek()->subWeek()->toDateTimeString(),
                    Carbon::now()->endOfWeek()->subWeek()->toDateTimeString(),
                ];
                break;
            case self::DATE_LAST_MONTH:
                $date = [
                    Carbon::now()->startOfMonth()->subMonth()->toDateTimeString(),
                    Carbon::now()->endOfMonth()->subMonth()->toDateTimeString(),
                ];
                break;
            case self::DATE_LAST_THREE_MOUTHS:
                $date = [
                    Carbon::now()->startOfMonth()->subMonths(3)->toDateTimeString(),
                    Carbon::now()->endOfMonth()->subMonths(3)->toDateTimeString(),
                ];
                break;
            case self::DATE_LAST_QUARTER:
                $date = [
                    Carbon::now()->startOfQuarter()->subQuarter()->toDateTimeString(),
                    Carbon::now()->endOfQuarter()->subQuarter()->toDateTimeString(),
                ];
                break;
            case self::DATE_LAST_YEAR:
                $date = [
                    Carbon::now()->startOfYear()->subYear()->toDateTimeString(),
                    Carbon::now()->endOfYear()->subYear()->toDateTimeString(),
                ];
                break;
            case self::DATE_LAST_THREE_YEARS:
                $date = [
                    Carbon::now()->startOfYear()->subYears(3)->toDateTimeString(),
                    Carbon::now()->endOfYear()->subYears(3)->toDateTimeString(),
                ];
                break;

            case self::DATE_LAST_WEEK_TO_TODAY:
                $date = [
                    Carbon::now()->startOfWeek()->subWeek()->toDateTimeString(),
                    Carbon::now()->toDateTimeString(),
                ];
                break;
            case self::DATE_LAST_MONTH_TO_TODAY:
                $date = [
                    Carbon::now()->startOfMonth()->subMonth()->toDateTimeString(),
                    Carbon::now()->toDateTimeString(),
                ];
                break;
            case self::DATE_LAST_QUARTER_TO_TODAY:
                $date = [
                    Carbon::now()->startOfQuarter()->subQuarter()->toDateTimeString(),
                    Carbon::now()->toDateTimeString(),
                ];
                break;
            case self::DATE_LAST_YEAR_TO_TODAY:
                $date = [
                    Carbon::now()->startOfYear()->subYear()->toDateTimeString(),
                    Carbon::now()->toDateTimeString(),
                ];
                break;
            case  self::DATE_PASSED_THIRTY_DAYS:
                $date = [
                    Carbon::now()->subDays(30)->toDateTimeString(),
                    Carbon::now()->toDateTimeString(),
                ];
                break;
            case  self::DATE_PASSED_SEVEN_DAYS:
                $date = [
                    Carbon::now()->subDays(7)->toDateTimeString(),
                    Carbon::now()->toDateTimeString(),
                ];
                break;
            case  self::DATE_PASSED_THREE_DAYS:
                $date = [
                    Carbon::now()->subDays(3)->toDateTimeString(),
                    Carbon::now()->toDateTimeString(),
                ];
                break;
        }

        return $date;
    }

}
