<?php

namespace Iyuu\SiteManager\Cookie;

use Iyuu\SiteManager\BaseCookie;
use Iyuu\SiteManager\Frameworks\NexusPhp\HasCookie;
use Iyuu\SiteManager\Spider\Pagination;

/**
 * hdzone
 * - 凭cookie解析HTML列表页
 */
class CookieHdzone extends BaseCookie
{
    use HasCookie, Pagination;
    /**
     * 站点名称
     */
    public const SITE_NAME = 'hdzone';

    /**
     * 是否调试当前站点
     * @return bool
     */
    protected function isDebugCurrent(): bool
    {
        return true;
    }
}
