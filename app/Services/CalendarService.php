<?php

namespace App\Services;

use Morilog\Jalali\Jalalian;


class CalendarService
{

    protected Jalalian $date;


    public function __construct($year = null, $month = null)
    {

        if ($year && $month) {

            $this->date = new Jalalian(
                $year,
                $month,
                1
            );

        } else {

            $now = Jalalian::now();

            $this->date = new Jalalian(
                $now->getYear(),
                $now->getMonth(),
                1
            );

        }

    }



    public function current()
    {
        return $this->date;
    }



    public function year()
    {
        return $this->date->getYear();
    }



    public function month()
    {
        return $this->date->getMonth();
    }



    public function title()
    {
        return $this->date->format('F Y');
    }



    public function daysCount()
    {
        return $this->date->getMonthDays();
    }



    /*
     ساختار روزهای ماه برای نمایش در Grid
    */
    public function days()
    {
        $days = [];
    
        for ($day = 1; $day <= $this->daysCount(); $day++) {
    
            $date = new Jalalian(
                $this->year(),
                $this->month(),
                $day
            );
    
            $days[] = [
                'day' => $day,
                'date' => $date,
                'is_today' => $this->isToday($day),
            ];
        }
    
        return $days;
    }

    /**
     * روز هفته شروع ماه
     */
    public function firstDayOfWeek()
    {
        return $this->date
            ->toCarbon()
            ->dayOfWeek;
    }


    /**
     * تعداد خانه‌های خالی قبل از روز اول ماه
     * چون تقویم ما از شنبه شروع می‌شود
     */
    public function emptyDays()
    {
        return ($this->firstDayOfWeek() + 1) % 7;
    }

    public function isToday($day)
    {
        $today = Jalalian::now();

        return 
            $this->year() == $today->getYear()
            &&
            $this->month() == $today->getMonth()
            &&
            $day == $today->getDay();
    }

    /*
    ماه قبل
    */
    public function previous()
    {
        if($this->month() == 1){

            return new Jalalian(
                $this->year() - 1,
                12,
                1
            );

        }


        return new Jalalian(
            $this->year(),
            $this->month() - 1,
            1
        );
    }



    /*
    ماه بعد
    */
    public function next()
    {
        if($this->month() == 12){

            return new Jalalian(
                $this->year() + 1,
                1,
                1
            );

        }


        return new Jalalian(
            $this->year(),
            $this->month() + 1,
            1
        );
    }

}
