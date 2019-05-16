<?php
    namespace ierusalim\BaseConvert;

    class Base85VC
    {
        public $bco;

        public function base85vc_decode($src) {
            if (!strlen($src)) {
                return '';
            }
            $s1251 = \mb_convert_encoding($src, 'cp1251','utf-8');
            $dec = $this->bco->basex_decode($s1251, 85);
            return hex2bin($this->bco->dectohex($dec));
        }

        public function base85vc_encode($src)
        {
            $dec = $this->bco->hextodec(bin2hex($src));
            $r1251 = $this->bco->basex_encode($dec, 85);
            return \mb_convert_encoding($r1251,'utf-8','cp1251');
        }

        public function __construct() {
            $this->bco = new \ierusalim\BaseConvert\BaseConvert(
                85,
                    '0123456789'
                  . 'ABCDEFGHJKLMNPQRSTUVWXYZ'
                  . 'abcdefghijkmnopqrstuvwxyz'
                  . \mb_convert_encoding('БГДЖИЛПФЦЧШЮЯ','cp1251','utf-8')
                  . \mb_convert_encoding('згджилпфцчшюя','cp1251','utf-8')
                );
        }
    }