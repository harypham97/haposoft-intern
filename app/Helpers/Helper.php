<?php

function getGuardName()
{
    if (Auth::guard('admin')->check()) {
        return "admin";
    } elseif (Auth::guard('web')->check()) {
        return "web";
    } elseif (Auth::guard('customer')->check())
        return "customer";
}
