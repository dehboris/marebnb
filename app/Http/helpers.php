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

if (!function_exists('is_route')) {
	/**
	 * Check if current route is equal to $route.
	 * 
	 * @param  string  $route Route to check
	 * @return boolean
	 */
	function is_route($route)
	{
		return \Route::currentRouteNamed($route) ? "active" : "";
	}
}