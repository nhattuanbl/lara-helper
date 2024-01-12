<?php

namespace Nhattuanbl\LaraHelper\Helpers;

use Illuminate\Http\Request;

class IpHelper
{
    public static function getUserIP(?Request $request = null): ?string
    {
        if ($request) {
            $server = $request->server->all();
        } else {
            $server = $_SERVER;
        }

        if (isset($server["HTTP_CF_CONNECTING_IP"])) {
            $server['REMOTE_ADDR'] = $server["HTTP_CF_CONNECTING_IP"];
            $server['HTTP_CLIENT_IP'] = $server["HTTP_CF_CONNECTING_IP"];
        }
        $client  = $server['HTTP_CLIENT_IP'] ?? null;
        $forward = $server['HTTP_X_FORWARDED_FOR'] ?? null;
        $remote  = $server['REMOTE_ADDR'] ?? null;

        if(filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $server["HTTP_CF_CONNECTING_IP"] ?? ($ip ?? \request()->ip());
    }
}
