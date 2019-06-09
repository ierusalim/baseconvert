<?php
namespace ierusalim\BaseConvert;

class vc85 extends BaseConvert
{
    public function __construct($ascii85_charset = false)
    {
        if ($ascii85_charset === true) {
            //  Base85 (ASCII85) character set
            $b85_chars = implode(range(chr(33), chr(117)));
        } elseif ($ascii85_charset === false) {
            // vc85  (Visual-unical characters with Cyrillic)
            $b85_chars = \mb_convert_encoding(
                    '0123456789'
                  . 'ABCDEFGHJKLMNPQRSTUVWXYZ'
                  . 'abcdefghijkmnopqrstuvwxyz'
                  . 'згджилпфцчшюэ'
                  . 'БГДЖИЛПФЦЧШЮЯ' , 'cp1251', 'utf-8');
        } elseif (strlen($ascii85_charset) == 85) {
            $b85_chars = $ascii85_charset;
        }
        parent::__construct(85, $b85_chars);
    }

    public function vc85_encode($src)
    {
        $first_c = $this->bases[85][0];
        $wrk_arr = str_split($src, 4);
        $last_k = count($wrk_arr) - 1;
        $last_s = $wrk_arr[$last_k];
        $last_a = 4 - strlen($last_s);
        if ($last_a) {
            $last_k--;
        }
        for($k = 0; $k <= $last_k; $k++) {
            $b85 = $this->basex_encode(unpack('N', $wrk_arr[$k])[1], 85);
            if ($a = 5 - strlen($b85)) {
                $b85 = str_repeat($first_c, $a) . $b85;
            }
            $wrk_arr[$k]= $b85;
        }
        if ($last_a && ($last_a < 4)) { // 1 (if 3 byte), 2 (if 2 byte), 3 (if 1 byte), 4 (empty)
            $s4 = str_repeat(chr(0), $last_a) . $last_s;
            $wrk_arr[$k] = str_pad(
                $this->basex_encode(unpack('N', $s4)[1], 85),
                5 - $last_a, $first_c, \STR_PAD_LEFT);
        }
        return implode($wrk_arr);
    }

    public function vc85_decode($src)
    {
        if (!strlen($src)) return '';

        $wrk_arr = str_split($src, 5);
        $last_k = count($wrk_arr) - 1;
        $last_s = $wrk_arr[$last_k];
        $last_a = 5 - strlen($last_s);
        if ($last_a) {
            $last_k--;
        }
        for($k = 0; $k <= $last_k; $k++) {
            $c4 = pack('N', $this->basex_decode($wrk_arr[$k], 85));
            if ($a = 4 - strlen($c4)) {
                $c4 = str_repeat(chr(0), $a) . $c4;
            }
            $wrk_arr[$k] = $c4;
        }
        if ($last_a) { // 1 (if 3 byte), 2 (if 2 byte), 3 (if 1 byte), 4 (if 1 byte)
            $dec = $this->basex_decode($last_s, 85);
            $wrk_arr[$k] = substr(pack('N', $dec), ($last_a < 3) ? $last_a : 3 - 4);
        }
        return implode($wrk_arr);
    }

}
