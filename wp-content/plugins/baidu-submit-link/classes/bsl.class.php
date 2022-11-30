<?php


class WB_BSL_Base
{

    public static function error($msg,$mod='')
    {
        WB_BSL_Utils::run_err($msg,$mod);
    }

    public static function info($msg,$mod='')
    {
        WB_BSL_Utils::run_log($msg,$mod);
    }

}