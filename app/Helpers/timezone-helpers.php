<?php

if (!function_exists('timezone_options')) {
    function timezone_options()
    {
        $timezones = DateTimeZone::listIdentifiers();
        $options = [];
        foreach ($timezones as $timezone) {
            $datetime = new DateTime('now', new DateTimeZone($timezone));
            $options[] = [
                'label' => '(UTC ' . $datetime->format('P') . ') ' . $timezone,
                'value' => $timezone,
            ];
        }
        return $options;
    }
}
if (!function_exists('timezones')) {
    function timezones()
    {
        return arr_map(timezone_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}
