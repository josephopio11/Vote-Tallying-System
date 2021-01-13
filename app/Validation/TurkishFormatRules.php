<?php

namespace App\Validation;

/**
 * Format validation Rules.
 *
 * @package CodeIgniter\Validation
 */
class TurkishFormatRules
{

    /**
     * Alpha
     *
     * @param string $str
     *
     * @return boolean
     */
    public function alpha_turkish(string $str = null, string &$error = null): bool
    {
        if ((bool) preg_match('/^[A-ZÇŞĞÜÖİçşğüöı]+$/i', $str))
        {
            return true;
        }

        $error = lang('validationturkish.alpha_turkish');
        return false;
    }

    //--------------------------------------------------------------------

    /**
     * Alpha with spaces.
     *
     * @param string $value Value.
     *
     * @return boolean True if alpha with spaces, else false.
     */
    public function alpha_space_turkish(string $str = null, string &$error = null): bool
    {
        if ($str === null)
        {
            return true;
        }

        if ((bool) preg_match('/^[A-Z ÇŞĞÜÖİçşğüöı]+$/i', $str))
        {
            return true;
        }

        $error = lang('validationturkish.alpha_space_turkish');
        return false;
    }

    //--------------------------------------------------------------------

    /**
     * Alpha-numeric with underscores and dashes
     *
     * @param string $str
     *
     * @return boolean
     */
    public function alpha_dash_turkish(string $str = null, string &$error = null): bool
    {

        if ((bool) preg_match('/^[a-z0-9_-ÇŞĞÜÖİçşğüöı]+$/i', $str))
        {
            return true;
        }
        $error = lang('validationturkish.alpha_dash_turkish');
        return false;
    }

    //--------------------------------------------------------------------

    /**
     * Alpha-numeric
     *
     * @param string $str
     *
     * @return boolean
     */
    public function alpha_numeric_turkish(string $str = null, string &$error = null): bool
    {
        if ((bool) preg_match('/^[A-Z0-9ÇŞĞÜÖİçşğüöı]+$/i', $str))
        {
            return true;
        }

        $error = lang('validationturkish.alpha_numeric_turkish');
        return false;
    }

    //--------------------------------------------------------------------

    /**
     * Alpha-numeric w/ spaces
     *
     * @param string $str
     *
     * @return boolean
     */
    public function alpha_numeric_space_turkish(string $str = null, string &$error = null): bool
    {
        if ((bool) preg_match('/^[A-Z0-9 ÇŞĞÜÖİçşğüöı]+$/i', $str))
        {
            return true;
        }

        $error = lang('validationturkish.alpha_numeric_space_turkish');
        return false;
    }

    //--------------------------------------------------------------------

    /**
     * Alphanumeric, spaces, and a limited set of punctuation characters.
     * Accepted punctuation characters are: ~ tilde, ! exclamation,
     * # number, $ dollar, % percent, & ampersand, * asterisk, - dash,
     * _ underscore, + plus, = equals, | vertical bar, : colon, . period
     * ~ ! # $ % & * - _ + = | : .
     *
     * @param string $str
     *
     * @return boolean
     */
    public function alpha_numeric_punct_turkish($str, string &$error = null)
    {
        if ((bool) preg_match('/^[A-Z0-9 ÇŞĞÜÖİçşğüöı~!#$%\&\*\-_+=|:.]+$/i', $str))
        {
            return true;
        }

        $error = lang('validationturkish.alpha_numeric_punct_turkish');
        return false;
    }

    //--------------------------------------------------------------------

    /**
     * Value should be within an array of values
     *
     * @param  string $value
     * @param  string $list
     * @param  array  $data
     * @return boolean
     */
    public function blacklist(string $value = null, string $list, array $data, string &$error = null): bool
    {
        $list = explode(',', $list);
        $list = array_map(function ($value)
        {
            return trim(strtolower($value));
        }, $list);

        if (in_array(strtolower($value), $list, true))
        {
            $error = lang('validationturkish.blacklist');
            return false;
        }
        return true;
    }

}
