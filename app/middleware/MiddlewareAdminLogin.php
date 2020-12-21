<?php


namespace App\middleware;


class MiddlewareAdminLogin
{

    /**
     * MiddlewareAdminLogin constructor.
     */
    public function __construct()
    {
        if (!isset($_SESSION['auth_admin'])) {
            if ($_SERVER['REQUEST_URI'] != "/cpm/admin") {
                redirect(route('admin'));
            }
        }
    }
}