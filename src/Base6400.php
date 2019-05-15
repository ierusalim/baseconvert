<?php
namespace ierusalim\BaseConvert;

class Base6400
{
    public $base64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';

    public function base6400_decode($str) {
        $b64 = '';
        $base6400 = 13312;
        $base64 = $this->base64;

        $b6400_arr = $this->explodeToUnicode($str);

        $cnt = count($b6400_arr) - 1;
        if ($cnt < 0) {
            return '';
        }
        $last = $b6400_arr[$cnt] - $base6400 - 4096;
        if ($last < 0) {
            $cnt++;
        }
        for($p = 0; $p<$cnt; $p++) {
            $n = $b6400_arr[$p] - $base6400;
            $f = (int)($n / 64);
            $s = $n - $f * 64;
            $b6400_arr[$p] = $base64[$f] . $base64[$s];
        }
        if ($last >= 0) {
            if ($last > 63) {
                $last = '==';
            } else {
                $last = $base64[$last] . '=';
            }
            $b6400_arr[$cnt] = $last;
        }
        $b64 = implode($b6400_arr);
        $ret = base64_decode($b64);
        return $ret;
    }
    public function base6400_encode($str)
    {
        $b64 = base64_encode($str);

        $base6400 = 13312;
        $base64 = $this->base64;

        $bar = str_split($b64,2);
        $cnt = count($bar)-1;
        if ($cnt<1) {
            return '';
        }
        if(substr($bar[$cnt],-1) == '=') {
            $f = substr($bar[$cnt],0,1);
            if ($f == '=') {
                $bar[$cnt] = $base6400 + 4096 + 64;
            } else {
                $bar[$cnt] = $base6400 + 4096 + strpos($base64, $bar[$cnt][0]);
            }

        } else {
            $cnt++;
        }
        for($p=0; $p<$cnt; $p++) {
            $f = strpos($base64, $bar[$p][0]);
            $s = strpos($base64, $bar[$p][1]);
            $bar[$p] = $base6400 + $f * 64 + $s;
        }

        return $this->implodeUnicode($bar);
    }

    /**
     *
     * @param string $str String data, in utf8 or $cp encode
     * @param string $cp utf-8 by default or other
     * @return array|false Array with unicode-numbers or false if error
     */
    public function explodeToUnicode(
	$str,
	$cp='utf-8'
    ) {
        if (!strlen($str)) {
            return [];
        }
	//Convert to ucs-4 (4 bytes per symbol)
	@$str_ucs4=iconv($cp,'ucs-4be',$str);
	//check errors
	$last_err=error_get_last();
	if(is_array($last_err)) {//if error
            if($last_err['type']==8) return false;
            //Unknown error
            throw new \Exception("ERROR explode_to_unicode: ". $last_err);
	}

	//Split string to array by 4 bytes per symbol
	$wrk_arr=str_split($str_ucs4,4);
	//Walk array and convert each element
	foreach($wrk_arr as $k=>$ch_ucs4) {
		//Convert string (4 bytes) to integer
		$n_arr=unpack('N',$ch_ucs4);
		//write back to array
		$wrk_arr[$k]=$n_arr[1];
	}
	//Return results
	return $wrk_arr;
    }

    public function implodeUnicode(
        $uni_arr,
        $to_cp='utf-8'
    ) {
        foreach($uni_arr as $k=>$n) {
            $uni_arr[$k] = \mb_convert_encoding('&#' . intval($n) . ';', $to_cp, 'HTML-ENTITIES');
        }
        return implode($uni_arr);
    }
}