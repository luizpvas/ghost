<?php

namespace App\Models\User;

trait Timezonable
{
    /**
     * Options to display timezones.
     * 
     * @return array
     */
    static function timezoneOptions()
    {
        $timezones = [];
        $offsets = [];
        $now = new \DateTime('now', new \DateTimeZone('UTC'));

        foreach (\DateTimeZone::listIdentifiers() as $timezone) {
            $now->setTimezone(new \DateTimeZone($timezone));
            $offsets[] = $offset = $now->getOffset();
            $timezones[$timezone] = '(' . self::timezoneGMTOffset($offset) . ') ' . self::timezoneFormatName($timezone);
        }

        array_multisort($offsets, $timezones);

        return $timezones;
    }

    static function timezoneGMTOffset($offset)
    {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    static function timezoneFormatName($name)
    {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }
}
