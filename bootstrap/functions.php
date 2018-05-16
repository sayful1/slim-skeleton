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
