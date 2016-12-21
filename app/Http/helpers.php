<?php

if (!function_exists('generate_token')) {
    /**
     * Generate random API token.
     *
     * @return string
     */
    function generate_token()
    {
        return str_random(60);
    }
}