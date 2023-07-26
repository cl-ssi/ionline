<?php

namespace App\Helpers;

use App\Models\Parameters\Holiday;

class DateHelper
{
    /**
     * Undocumented function
     *
     * @param  [type] $startDate
     * @param  [type] $endDate
     * @return \Illuminate\Support\Collection
     */
    public static function getBusinessDaysByDateRange($startDate, $endDate)
    {
        $holidays = Holiday::all(); // TODO: mejorar query

        $holidays = $holidays->map(function($holiday) {
            return $holiday->date->format('Y-m-d');
        });

        $weekend = collect([0, 6]);

        $startDate = $startDate->copy()->startOfDay();

        $businessDays = collect();

        while($startDate->lt($endDate))
        {
            if($holidays->doesntContain($startDate->format('Y-m-d')) && $weekend->doesntContain($startDate->dayOfWeek))
            {
                $businessDays->push($startDate->format('Y-m-d'));

            }

            $startDate = $startDate->copy()->addDay();
        }

        return $businessDays;
    }

    // eliminar
    public function getLeftBusinessDaysAttribute($startDate, $duration)
    {
        $holidays = Holiday::where('date', '>=', now())->get();

        $holidays = $holidays->map(function($holiday) {
            return $holiday->date->format('Y-m-d');
        });

        $startDate = $startDate->startOfDay();

        $end = now();

        $i = 0;

        $weekend = collect([0, 6]);

        while($startDate->lt($end))
        {
            if($holidays->doesntContain($startDate->format('Y-m-d')) && $weekend->doesntContain($startDate->dayOfWeek))
            {
                $i++;
            }

            $startDate = $startDate->copy()->addDay();
        }

        return $duration - $i;

    }

    /**
     * Undocumented function
     *
     * @param  mixed  $startDate
     * @param  mixed  $duration
     * @return \Illuminate\Support\Collection
     */
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