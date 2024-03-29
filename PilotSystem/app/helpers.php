<?php

if (!function_exists('in_mask')) {
    /**
     * Return true/false if a value exists in a mask
     *
     * @param $mask
     * @param $value
     *
     * @return bool
     */
    function in_mask($mask, $value)
    {
        return ($mask & $value) === $value;
    }
}

if (!function_exists('get_truth_state')) {
    /**
     * Check if the passed state matches any of the states that
     * we regard as being true or false
     *
     * @param $state
     *
     * @return bool
     */
    function get_truth_state($state)
    {
        $enabledStates = [
            'yes',
            'y',
            'on',
            'true',
            '1',
            true,
        ];

        if (is_string($state)) {
            $state = strtolower($state);
        }

        return \in_array($state, $enabledStates, false);
    }
}

if (!function_exists('list_to_assoc')) {
    /**
     * Converts a straight list into an assoc array with
     * key and value being the same. Mainly for a select box
     *
     * e.g.:
     *    [ 0 => 'item1', 1 => 'item2']
     * to:
     *    ['item1' => 'item1', 'item2' => 'item2']
     *
     * @param array $list
     *
     * @return array
     */
    function list_to_assoc(array $list)
    {
        $ret = [];
        foreach ($list as $item) {
            if (substr_count($item, '=')) {
                [$item, $title] = explode('=', $item);
            } else {
                $title = $item;
            }

            $ret[$item] = $title;
        }

        return $ret;
    }
}

if (!function_exists('list_to_editable')) {
    /**
     * Convert a list (select box) into an editable list
     * https://vitalets.github.io/x-editable/docs.html#select
     * Takes a list of:
     *    [value => text, valueN => textN, ...]
     * Return:
     *    [{value: 1, text: "text1"}, {value: 2, text: "text2"}, ...]
     *
     * @param array $list
     *
     * @return array
     */
    function list_to_editable(array $list)
    {
        $editable = [];
        foreach ($list as $value => $key) {
            $editable[] = [
                'text'  => $key,
                'value' => $value,
            ];
        }

        return $editable;
    }
}

if (!function_exists('skin_view')) {
    /**
     * Render a skin
     *
     * @param       $template
     * @param array $vars
     * @param array $merge_data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    function skin_view($template, array $vars = [], array $merge_data = [])
    {
        // Add the current skin name so we don't need to hardcode it in the templates
        // Makes it a bit easier to create a new skin by modifying an existing one
        if (View::exists($template)) {
            return view($template, $vars, $merge_data);
        }

        // TODO: Look for an overridden template in a special folder
        $tpl = 'layouts/'.config('phpvms.skin').'/'.$template;

        return view($tpl, $vars, $merge_data);
    }
}

/*
 * Shortcut for retrieving a setting value
 */
if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        $settingRepo = app('setting');

        try {
            $value = $settingRepo->retrieve($key);
        } catch (\App\Exceptions\SettingNotFound $e) {
            return $default;
        }

        return $value;
    }
}

/*
 * Show a date/time in the proper timezone for a user
 */
if (!function_exists('show_datetime')) {
    /**
     * Format the a Carbon date into the datetime string
     * but convert it into the user's timezone
     *
     * @param \Carbon\Carbon $date
     *
     * @return string
     */
    function show_datetime(\Carbon\Carbon $date = null)
    {
        if ($date === null) {
            return '-';
        }

        $timezone = 'UTC';
        if (Auth::check()) {
            $timezone = Auth::user()->timezone ?: $timezone;
        }

        return $date->timezone($timezone)->toDayDateTimeString();
    }
}

/*
 * Show a date/time in the proper timezone for a user
 */
if (!function_exists('show_date')) {
    /**
     * Format the a Carbon date into the datetime string
     * but convert it into the user's timezone
     *
     * @param \Carbon\Carbon $date
     *
     * @return string
     */
    function show_date(\Carbon\Carbon $date)
    {
        $timezone = 'UTC';
        if (Auth::check()) {
            $timezone = Auth::user()->timezone ?: $timezone;
        }

        return $date->timezone($timezone)->toFormattedDateString();
    }
}

if (!function_exists('_fmt')) {
    /**
     * Replace strings
     *
     * @param       $line    "Hi, my name is :name"
     * @param array $replace ['name' => 'Nabeel']
     *
     * @return mixed
     */
    function _fmt($line, array $replace)
    {
        if (empty($replace)) {
            return $line;
        }

        foreach ($replace as $key => $value) {
            $key = strtolower($key);
            $line = str_replace(
                [':'.$key],
                [$value],
                $line
            );
        }

        return $line;
    }
}

if (!function_exists('print_flight_time')) {
    function print_flight_time($seconds)
    {
        return floor($seconds / 3600) . '时' . gmdate(":i分:s秒", $seconds % 3600);
    }
}

if (!function_exists('randStr')) {
    function randStr($len=6,$format='ALL') {
        switch($format) {
            case 'ALL':
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~'; break;
            case 'CHAR':
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-@#~'; break;
            case 'NUMBER':
                $chars='0123456789'; break;
            default :
                $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-@#~';
                break;
        }
        mt_srand((double)microtime()*1000000*getmypid());
        $password="";
        while(strlen($password)<$len)
            $password.=substr($chars,(mt_rand()%strlen($chars)),1);
        return $password;
    }
}