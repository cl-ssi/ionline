<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use App\Models\Parameters\Holiday;
// use App\Models\Parameters\Holiday;

class DateHelper
{
    /**
     * Gets the business days for a date range
     *
     * @param  \Illuminate\Support\Carbon  $startDate
     * @param  \Illuminate\Support\Carbon  $endDate
     * @return \Illuminate\Support\Collection
     */
    public static function getBusinessDaysByDateRange($startDate, $endDate)
    {
        $holidays = Cache::remember('holidays', 600, function () use($startDate, $endDate) {
            return Holiday::whereBetween('date', [$startDate, $endDate])->get();
        });

        // $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->get();

        $holidays = $holidays->map(function($holiday) {
            return $holiday->date->format('Y-m-d');
        });

        $weekend = collect([0, 6]);

        $startDate = $startDate->copy()->startOfDay();

        $businessDays = collect();

        while($startDate->lessThanOrEqualTo($endDate))
        {
            if($holidays->doesntContain($startDate->format('Y-m-d')) && $weekend->doesntContain($startDate->dayOfWeek))
            {
                $businessDays->push($startDate->format('Y-m-d'));
            }

            $startDate = $startDate->copy()->addDay();
        }

        return $businessDays;
    }

    /**
     * Gets the business days for a date range
     *
     * @param  \Illuminate\Support\Carbon  $startDate
     * @param  \Illuminate\Support\Carbon  $endDate
     * @param  \Illuminate\Support\Holiday  $endDate
     * @return \Illuminate\Support\Collection
     */
    public static function getBusinessDaysByDateRangeHolidays($startDate, $endDate, $holidays)
    {
        // $holidays = Cache::remember('holidays', 600, function () use($startDate, $endDate) {
        //     return Holiday::whereBetween('date', [$startDate, $endDate])->get();
        // });

        // $holidays = Holiday::whereBetween('date', [$startDate, $endDate])->get();

        $holidays = $holidays->map(function($holiday) {
            return $holiday->date->format('Y-m-d');
        });

        $weekend = collect([0, 6]);

        $startDate = $startDate->copy()->startOfDay();

        $businessDays = collect();

        while($startDate->lessThanOrEqualTo($endDate))
        {
            if($holidays->doesntContain($startDate->format('Y-m-d')) && $weekend->doesntContain($startDate->dayOfWeek))
            {
                $businessDays->push($startDate->format('Y-m-d'));
            }

            $startDate = $startDate->copy()->addDay();
        }

        return $businessDays;
    }

    /**
     * Gets the business days given a start and a duration
     *
     * @param  \Illuminate\Support\Carbon  $startDate
     * @param  int  $duration
     * @return \Illuminate\Support\Collection
     */
    // Asi lo tenía el Torres lo voy a dejar como lo venia Rafael
    // public static function getBusinessDaysByDuration($startDate, $duration)
    // {
    //     $holidays = Cache::remember('holidays', 600, function () use($startDate, $duration) {
    //         return Holiday::whereBetween('date', [$startDate, $duration])->get();
    //     });

    //     $holidays = $holidays->map(function($holiday) {
    //         return $holiday->date->format('Y-m-d');
    //     });

    //     $start = $startDate->copy()->startOfDay();

    //     $i = 0;

    //     $weekend = collect([0, 6]);

    //     $businessDays = collect();

    //     while($i < $duration)
    //     {
    //         if($holidays->doesntContain($start->format('Y-m-d')) && $weekend->doesntContain($start->dayOfWeek))
    //         {
    //             $businessDays->push($start->format('Y-m-d'));

    //             $i++;
    //         }

    //         $start = $start->copy()->addDay();
    //     }

    //     return $businessDays;
    // }


    public static function getBusinessDaysByDuration($startDate, $duration)
    {
        $holidays = Holiday::all(); // TODO: mejorar query

        $holidays = $holidays->map(function($holiday) {
            return $holiday->date->format('Y-m-d');
        });

        $start = $startDate->copy()->startOfDay();

        $i = 0;

        $weekend = collect([0, 6]);

        $businessDays = collect();

        while($i < $duration)
        {
            if($holidays->doesntContain($start->format('Y-m-d')) && $weekend->doesntContain($start->dayOfWeek))
            {
                $businessDays->push($start->format('Y-m-d'));

                $i++;
            }

            $start = $start->copy()->addDay();
        }

        return $businessDays;
    }



}