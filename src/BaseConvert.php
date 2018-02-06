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
    public $bases = [
        2 => '01',
        3 => '012',
        4 => '0123',
        8 => '01234567',
        10 => '0123456789',
        16 => '0123456789abcdef',
        58 => '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz',
    ];
    public $base_default;

    public function __construct($base_default = 16, $base_charset = false) {
        $this->base_default = $base_default;
        if (!empty($base_charset)) {
            $this->bases[$base_default] = $base_charset;
        }
    }

    public function basex_decode($src, $base = false) {
        if ($base === false) {
            $base = $this->base_default;
        }
        if (!isset($this->bases[$base])) {
            return false;
        }
        $r='0';
        for($i=0; $i < \strlen($src); $i++) {
            $ch = $src[$i];
            $c = \strpos($this->bases[$base], $src[$i]);
            $r = (string)\bcmul($r, $base, 0);
            $r = (string)\bcadd($r, $c, 0);
        }
        return $r;
    }

    public function basex_encode($dec, $base = false) {
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

    public function dectohex($dec) {
        $hex = $dec ? $this->basex_encode($dec, 16) : 0;
        return (\strlen($hex) % 2)  ? '0' . $hex : $hex;
    }

    public function hextodec($hex) {
        return $this->basex_decode(\strtolower($hex), 16);
    }

    public function dectobits($dec) {
        return ($dec > 0) ? $this->basex_encode($dec, 2) : '0';
    }

    public function bitstodec($bits) {
        return $this->basex_decode($bits, 2);
    }

    public function hextobits($hex) {
        $dec = $this->hextodec($hex);
        return ($dec > 0) ? $this->basex_encode($dec, 2) : '0';
    }

    public function bitstohex($bits) {
        $dec = $this->bitstodec($bits);
        return $this->dectohex($dec);
    }

    public function dectobase58($dec) {
        return ($dec > 0) ? $this->basex_encode($dec, 58) : '1';
    }

    public function hextobase58($hex) {
        $dec = $this->hextodec($hex);
        return $this->dectobase58($dec);
    }

    public function base58tohex($b58) {
        $dec = $this->basex_decode($b58, 58);
        return $this->dectohex($dec);
    }
}
