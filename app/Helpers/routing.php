<?php

/**
 * Compare given route with current route and return output if they match.
 *
 * @param $route
 * @param null $paramName
 * @param null $paramValue
 * @param string $output
 * @return null|string
 */
function isActiveRoute($route, $paramName = NULL, $paramValue = NULL, $output = ' active')
{
    if(Route::currentRouteName() == $route) {
        if($paramName != NULL && $paramValue != NULL && Route::input($paramName)->id != $paramValue->id)
            return NULL;

        return $output;
    }

    return NULL;
}