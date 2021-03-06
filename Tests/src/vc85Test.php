<?php
namespace ierusalim\BaseConvert;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2019-05-17 at 16:41:13.
 */
class vc85Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @var vc85
     */
    protected $object;

    public $man_str = 'Man is distinguished, not only by his reason, but by this singular '
                    . 'passion from other animals, which is a lust of the mind, that by a '
                    . 'perseverance of delight in the continued and indefatigable generation '
                    . 'of knowledge, exceeds the short vehemence of any carnal pleasure.';

    public $man_85_utf = 'QГЦПдZЖпbCZЖчZGbhA9Ad7шBЦEFhэidTejVaГXDKeФ3цNd0BjNXTMX8EFhbcdTe4TAcu'
                    . 'RHd0BnTbhA9DXT9iFXTMj7bшCзFcфLчSbшшy7cyччDZЖDQФd1YewZoaШБAbeИVXJZZEd'
                    . '95naYшЯHEYixБ7bgпRXdbB98AaгtUXJZm2cфxшPYsbJШXЦWц3YшЮuЦaэzmЦdTeRPAcuR'
                    . 'DAaшVCdbLvPYqЖПЖbgлЖ7bgцTГXTWJЧXRd4лAbLP6YsbK3ZЖXЖJbчRBCbhШиPYqПdпEF'
                    . 'hkiXЦZKдd0BqTYiy5CbшsЦZe4eVЯbDqsФYixП6AasELAaчБ2bggW7cBQ8Пd9HkN0n';

    public $man_85a_utf = 'QГЦПдZЖпbCZЖчZGbhA9Ad7шBЦEFhэidTejVaГXDKeФ3цNd0BjNXTMX8EFhbcdTe4TAcu'
                    . 'RHd0BnTbhA9DXT9iFXTMj7bшCзFcфLчSbшшy7cyччDZЖDQФd1YewZoaШБAbeИVXJZZEd'
                    . '95naYшЯHEYixБ7bgпRXdbB98AaгtUXJZm2cфxшPYsbJШXЦWц3YшЮuЦaэzmЦdTeRPAcuR'
                    . 'DAaшVCdbLvPYqЖПЖbgлЖ7bgцTГXTWJЧXRd4лAbLP6YsbK3ZЖXЖJbчRBCbhШиPYqПdпEF'
                    . 'hkiXЦZKдd0BqTYiy5CbшsЦZe4eVЯbDqsФYixП6AasELAaчБ2bggW7cBQ8Пd9HkNn';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new vc85(false);
    }

    public function testConstruct()
    {
        $len = strlen($this->object->bases[85]);
        $this->assertEquals(85, $len);

        $bc = new vc85(true);

        $base85vc = $bc->bases[85];

        $len = strlen($base85vc);
        $this->assertEquals(85, $len);

        $z85 = new vc85("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz.-:+=^!/*?&<>()[]{}@%$#");
        $base85vc = $bc->bases[85];

        $len = strlen($base85vc);
        $this->assertEquals(85, $len);

        $bc = new vc85();

        $str = "One day I'm gonna fly away One day when heavens calls my name";
        $enc = $bc->vc85_encode($str);

        echo "result: $enc \n";
        $back = $bc->vc85_decode($enc);

        echo ($str === $back) ? "OK" : "Fail";
    }


    /**
     * @covers ierusalim\BaseConvert\vc85::vc85_encode
     * @todo   Implement testVc85_encode().
     */
    public function testVc85_encode()
    {
        $o = $this->object;

        // empty string test
        $str = '';
        $enc = $o->vc85_encode($str);
        $this->assertEquals('', $enc);

        // pre-defined strings test
        $src = $this->man_str;
        $enc = $o->vc85_encode($src);
        $exp_enc_1251 = mb_convert_encoding($this->man_85_utf, 'cp-1251', 'utf-8');
        $this->assertEquals($exp_enc_1251, $enc);

        // random strings test
        foreach([0,1,64,84,85,86,255] as $j) {
            $first3 = chr(0) . chr(0) . chr($j);

            for ($i=0; $i<256; $i++) {
                $str = $first3 . chr($i);
                // encoding to base85vc
                $enc = $o->vc85_encode($str);
                // back decoding from base85vc
                $dec = $o->vc85_decode($enc);
                if ($dec != $str) {
                    $enc_v = implode(' ', str_split($enc,5));
                    $str_v = implode('-',str_split(bin2hex($str),8));
                    $dec_v = implode('-',str_split(bin2hex($dec),8));
                    print_r(compact('str_v', 'enc_v', 'dec_v'));
                    $this->assertEquals($str, $dec);
                }
            }
        }

    }

    /**
     * @covers ierusalim\BaseConvert\vc85::vc85_decode
     * @todo   Implement testVc85_decode().
     */
    public function testVc85_decode()
    {
        $o = $this->object;

        $enc_src_1251 = mb_convert_encoding($this->man_85_utf, 'cp-1251', 'utf-8');
        $decoded = $o->vc85_decode($enc_src_1251);
        $this->assertEquals($this->man_str, $decoded);

        $enc_src_1251 = mb_convert_encoding($this->man_85a_utf, 'cp-1251', 'utf-8');
        $decoded = $o->vc85_decode($enc_src_1251);
        $this->assertEquals($this->man_str, $decoded);


        for($j=0; $j<10; $j++)
        {
            $str = '';
            for($i=0; $i<17; $i++) {
                $res = $o->vc85_encode($str);
                $dec = $o->vc85_decode($res);
                if ($dec != $str) {
                    var_dump(implode(' ', str_split($res,5)));
                    var_dump(implode('-',str_split(bin2hex($str),8)));
                    var_dump(implode('-',str_split(bin2hex($dec),8)));
                }
                $this->assertEquals($str, $dec);
                $str .= chr(rand(0,255));
            }
        }
    }
}
