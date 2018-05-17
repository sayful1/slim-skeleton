<?php

if ( ! function_exists('dd')) {
    /**
     * Die in dump
     *
     * @param $data
     */
    function dd($data)
    {
        var_dump($data);
        die();
    }
}

if ( ! function_exists('public_path')) {
    /**
     * Get public path
     *
     * @param null $folder
     *
     * @return string
     */
    function public_path($folder = null)
    {
        if ($folder) {
            return dirname(__DIR__) . "/public/{$folder}";
        }

        return dirname(__DIR__) . '/public/';
    }
}

if ( ! function_exists('process_time')) {
    /**
     * @param float $start_time
     * @param float $current_time
     *
     * @return string
     */
    function process_time($start_time = null, $current_time = null)
    {
        if (empty($start_time)) {
            $start_time = APPLICATION_START_TIME;
        }
        if (empty($current_time)) {
            $current_time = microtime(true);
        }
        $runtime = number_format($current_time - $start_time, 6) . ' seconds';

        return $runtime;
    }
}
