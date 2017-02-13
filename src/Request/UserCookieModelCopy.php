<?php

namespace xltxlm\h5skin\Request;

use \xltxlm\helper\Hclass\CopyObjectAttributeName;

/**
 * 获取类 UserCookieModel 的属性名称
 */
class UserCookieModelCopy
{
    use CopyObjectAttributeName;

            protected $username;

        /**
         * @return string
         */
        public static function username() :string
        {
            return (self::selfInstance())->varname(self::selfInstance()->username);
        }
            protected $sign;

        /**
         * @return string
         */
        public static function sign() :string
        {
            return (self::selfInstance())->varname(self::selfInstance()->sign);
        }
            protected $prepage;

        /**
         * @return string
         */
        public static function prepage() :string
        {
            return (self::selfInstance())->varname(self::selfInstance()->prepage);
        }
            protected $pageID;

        /**
         * @return string
         */
        public static function pageID() :string
        {
            return (self::selfInstance())->varname(self::selfInstance()->pageID);
        }
    }
