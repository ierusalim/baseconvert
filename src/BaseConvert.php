<?php
namespace ierusalim\BaseConvert;

/**
 * This class contains BaseConvert
 *
 * PHP Version >= 5.3, ext-bcmath required
 *
 * @package    ierusalim\BaseConvert
 * @author     Alexander Jer <alex@ierusalim.com>
 * @copyright  2018, Ierusalim
 * @license    https://opensource.org/licenses/Apache-2.0 Apache-2.0
 */
class BaseConvert
{

    /**
     * Base-ID => base-chars-string
     * 2 => binary
     * 8 => octal
     * 16 (default) => hex
     * 58 => bitcoin-compatible base58
     *
     * @var array of string
     */
    public $bases = [
        2 => '01',
        3 => '012',
        4 => '0123',
        8 => '01234567',
        10 => '0123456789',
        16 => '0123456789abcdef',
        58 => '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz',
    ];

    public $hex = [
        '0' => '0000',
        '1' => '0001',
        '2' => '0010',
        '3' => '0011',
        '4' => '0100',
        '5' => '0101',
        '6' => '0110',
        '7' => '0111',
        '8' => '1000',
        '9' => '1001',
        'a' => '1010',
        'b' => '1011',
        'c' => '1100',
        'd' => '1101',
        'e' => '1110',
        'f' => '1111',
    ];

    /**
     * Base-id for use in basex_encode/decode functions by default
     *
     * @var integer
     */
    public $base_default;

    /**
     * Initialization: in parameters can define any base-id => user-defined-characters
     * Usually no need to define parameters.
     *
     * @param integer|string $base_default
     * @param string $base_charset
     */
    public function __construct($base_default = 16, $base_charset = false)
    {
        $this->base_default = $base_default;
        if (!empty($base_charset)) {
            $this->bases[$base_default] = $base_charset;
        }
    }

    /**
     * Decode string from specified base to decimal representation of arbitrary precision
     *
     * @param string $src
     * @param integer|string $base
     * @return string|false
     */
    public function basex_decode($src, $base = false)
    {
        if ($base === false) {
            $base = $this->base_default;
        }
        if (!isset($this->bases[$base])) {
            return false;
        }
        $r = '0';
        for ($i = 0; $i < \strlen($src); $i++) {
            $ch = $src[$i];
            $c = \strpos($this->bases[$base], $src[$i]);
            if ($c === false) {
                return false;
            }
            $r = (string) \bcmul($r, $base, 0);
            $r = (string) \bcadd($r, $c, 0);
        }
        return $r;
    }

    /**
     * Convert from decimal representation of arbitrary precision to specified base
     *
     * @param string $dec
     * @param integer|string $base
     * @return string|false
     */
    public function basex_encode($dec, $base = false)
    {
        if ($base === false) {
            $base = $this->base_default;
        }
        if (!isset($this->bases[$base])) {
            return false;
        }
        $r = '';
        while (\bccomp($dec, 0) == 1) {
            $dv = (string) bcdiv($dec, $base, 0);
            $i = (integer) bcmod($dec, $base);
            $dec = $dv;
            $r = $r . $this->bases[$base][$i];
        }
        return \strrev($r);
    }

    /**
     * Convert from decimal representation of arbitrary precision to hex
     *
     * Negative values not supported
     *
     * @param string $dec
     * @return string
     */
    public function dectohex($dec)
    {
        $hex = ($dec > 0) ? $this->basex_encode($dec, 16) : 0;
        return (\strlen($hex) % 2) ? '0' . $hex : $hex;
    }

    /**
     * Convert from hex to decimal representation of arbitrary precision
     *
     * @param string $hex
     * @return string
     */
    public function hextodec($hex)
    {
        return $this->basex_decode(\strtolower($hex), 16);
    }

    /**
     * Convert from decimal representation of arbitrary precision to bits
     *
     * @param string $dec
     * @return string
     */
    public function dectobits($dec)
    {
        return ($dec > 0) ? $this->basex_encode($dec, 2) : '0';
    }

    /**
     * Convert to decimal representation of arbitrary precision from bits
     *
     * @param string $bits
     * @return string
     */
    public function bitstodec($bits)
    {
        return $this->basex_decode($bits, 2);
    }

    /**
     * Convert from hex to bits through decimal representation of arbitrary precision
     *
     * @param string $hex
     * @return string
     */
    public function hextobits($hex)
    {
        $dec = $this->hextodec($hex);
        return ($dec > 0) ? $this->basex_encode($dec, 2) : '0';
    }

    /**
     * Convert from hex string to bits string (quick algorithm)
     *
     * @param srting $hex
     * @return string
     */
    public function hextobitsQuick($hex, $removeLeftZeros = false)
    {
        $res = [];
        $harr = $this->hex;
        $hexlower = \strtolower($hex);
        $l = \strlen($hex);
        for($i = 0; $i < $l; $i++) {
            $c = $hexlower[$i];
            $res[] = $harr[$c];
        }
        $res = \implode('', $res);
        if ($removeLeftZeros) {
            $res = \ltrim($res, '0');
        }
        return $res;
    }

    /**
     * Convert binary string to bits-format (base-2)
     *
     * @param string $bin
     * @param boolean $removeLeftZeros
     * @return string
     */
    public function bintobits($bin, $removeLeftZeros = false) {
        $hex = bin2hex($bin);
        return $this->hextobitsQuick($hex, $removeLeftZeros);
    }

    /**
     * Convert from bits to hex through decimal representation of arbitrary precision
     *
     * @param string $bits
     * @return string
     */
    public function bitstohex($bits)
    {
        $dec = $this->bitstodec($bits);
        return $this->dectohex($dec);
    }

    /**
     * Convert from base58 to decimal representation of arbitrary precision
     *
     * @param string $dec
     * @return string (decimal digits)
     */
    public function dectobase58($dec)
    {
        return ($dec > 0) ? $this->basex_encode($dec, 58) : '1';
    }

    /**
     * Convert from hex to bitcoin-compatible base58
     *
     * @param string $hex (decimal digits)
     * @return string
     */
    public function hextobase58($hex)
    {
        $dec = $this->hextodec($hex);
        return $this->dectobase58($dec);
    }

    /**
     * Convert from bitcoin-compatible base58 to hex
     *
     * @param string $b58
     * @return string
     */
    public function base58tohex($b58)
    {
        $dec = $this->basex_decode($b58, 58);
        return $this->dectohex($dec);
    }
}
