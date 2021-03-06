<?php
namespace ierusalim\BaseConvert;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-02-06 at 08:59:58.
 */
class BaseConvertTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BaseConvert
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new BaseConvert;
    }

    public function testConstruct()
    {
        $base_def = 5;
        $base_chr = '01234';

        $bc = new BaseConvert($base_def, $base_chr);
        $this->assertEquals($bc->base_default, $base_def);

        $dec = 255;
        $chk1 = $bc->basex_encode($dec);
        $chk2 = $bc->basex_encode($dec, $base_def);
        $this->assertEquals($chk1, $chk2);

        $this->assertEquals($base_chr, $bc->bases[$base_def]);
    }

    /**
     * Provider of decimal <-> hex <-> base58
     *
     * @return array
     */
    public function decHexB58Provider()
    {
        return [
            [0, '0','1'],
            [255, 'ff','5Q'],
            [256, '100','5R'],
            [1234, '4d2', 'NH'],
            [12345, '3039', '4fr'],
            [123456, '1e240', 'dhZ'],
            [1234567, '12d687', '7Kze'],
            [12345678, 'bc614e', '26GwX'],
            [123456789, '75bcd15', 'BukQL'],
            [1234567890, '499602d2', '2t6V2H'],
            [12345678901, '2dfdc1c35', 'KowqDn'],
            [123456789012, '1cbe991a14', '4F6TKCo'],
            [1234567890123, '11f71fb04cb', 'ZRwY92z'],
            [12345678901234, 'b3a73ce2ff2', '6bJQNPLu'],
            [123456789012345, '7048860ddf79', 'xv12grS4'],
            [1234567890123456, '462d53c8abac0', 'Ae91HsXKd'],
            [12345678901234567, '2bdc545d6b4b87', '2fQP3uiEDL'],
            [123456789012345678, '1b69b4ba630f34e', 'Hd2oW67H8R'],
            [1234567890123456789, '112210f47de98115', '3sDK21t5nHJ'],
            ['12345678901234567890', 'ab54a98ceb1f0ad2', 'Vf87B9opoow'],
            ['123456789012345678901', '6b14e9f812f366c35', '5waE4kX5F56L'],
            ['1234567890123456789012', '42ed123b0bd8203a14', 'rQjFeWBjRhvK'],
            ['12345678901234567890123', '29d42b64e76714244cb', '9X6HXU2rKG4CA'],
            ['123456789012345678901234', '1a249b1f10a06c96aff2', '2UBurFfKW9bYvd'],
            ['1234567890123456789012345', '1056e0f36a6443de2df79', 'Fgt7VXcC2UxWFJ'],
            ['12345678901234567890123456', 'a364c98227eaa6adcbac0', '3Xsp7vH4uFpa3U3'],
            ['123456789012345678901234567', '661efdf158f2a82c9f4b87', 'SKm8CBmg1ZChRfU'],
            ['1234567890123456789012345678', '3fd35eb6d797a91be38f34e', '5NEcEvrhj6Z1yFdo'],
            ['12345678901234567890123456789', '27e41b3246bec9b16e398115', 'kfM5QHa2FxXAhXM6'],
            ['123456789012345678901234567890', '18ee90ff6c373e0ee4e3f0ad2', '8XcTm1rhDaaCfzETs'],
        ];
    }

    /**
     * Provider of decimal <-> bits
     *
     * @return array
     */
    public function decBitsProvider()
    {
        return [
            ['0', '0'],
            ['1', '1'],
            ['2', '10'],
            ['3', '11'],
            ['4', '100'],
            ['5', '101'],
            ['7', '111'],
            ['8', '1000'],
            ['9', '1001'],
            ['10', '1010'],
            ['15', '1111'],
            ['16', '10000'],
            ['32', '100000'],
            ['64', '1000000'],
            ['128', '10000000'],
            ['255', '11111111'],
            ['256', '100000000'],
            ['1234', '10011010010'],
            ['12345', '11000000111001'],
            ['123456', '11110001001000000'],
            ['1234567', '100101101011010000111'],
            ['12345678', '101111000110000101001110'],
            ['123456789', '111010110111100110100010101'],
            ['1234567890', '1001001100101100000001011010010'],
            ['12345678901', '1011011111110111000001110000110101'],
            ['123456789012', '1110010111110100110010001101000010100'],
            ['1234567890123', '10001111101110001111110110000010011001011'],
            ['12345678901234', '10110011101001110011110011100010111111110010'],
            ['123456789012345', '11100000100100010000110000011011101111101111001'],
            ['1234567890123456', '100011000101101010100111100100010101011101011000000'],
            ['12345678901234567', '101011110111000101010001011101011010110100101110000111'],
            ['123456789012345678', '110110110100110110100101110100110001100001111001101001110'],
            ['1234567890123456789', '1000100100010000100001111010001111101111010011000000100010101'],
            ['12345678901234567890', '1010101101010100101010011000110011101011000111110000101011010010'],
            ['123456789012345678901', '1101011000101001110100111111000000100101111001101100110110000110101'],
            ['1234567890123456789012', '10000101110110100010010001110110000101111011000001000000011101000010100'],
            ['12345678901234567890123', '10100111010100001010110110010011100111011001110001010000100100010011001011'],
            ['123456789012345678901234', '11010001001001001101100011111000100001010000001101100100101101010111111110010'],
            ['1234567890123456789012345', '100000101011011100000111100110110101001100100010000111101111000101101111101111001'],
            ['12345678901234567890123456', '101000110110010011001001100000100010011111101010101001101010110111001011101011000000'],
            ['123456789012345678901234567', '110011000011110111111011111000101011000111100101010100000101100100111110100101110000111'],
            ['1234567890123456789012345678', '111111110100110101111010110110110101111001011110101001000110111110001110001111001101001110'],
            ['12345678901234567890123456789', '1001111110010000011011001100100100011010111110110010011011000101101110001110011000000100010101'],
            ['123456789012345678901234567890', '1100011101110100100001111111101101100001101110011111000001110111001001110001111110000101011010010'],
        ];
    }

    /**
     * Provider of hex <-> bits
     *
     * @return array
     */
    public function hexBitsProvider()
    {
        $bc = new BaseConvert;
        $arr = $this->decBitsProvider();
        $res = [];
        foreach($arr as $el) {
            $dec = $el[0];
            $hex = $bc->dectohex($dec);
            $res[] = [$hex, $el[1]];
        }
        return $res;
    }

    /**
     * Provider of bin <-> bits
     *
     * @return array
     */
    public function binBitsProvider()
    {
        return [
            [' ' , '00100000', 0],
            [' ' , '100000', 1],
            ['  ' , '0010000000100000', 0],
            ['  ' , '10000000100000', 1],
            ['a ' , '0110000100100000', 0],
            ['a ' , '110000100100000', 1],
            //        HHHHHHHHeeeeeeeelllllllllllllllloooooooo
            ['Hello','0100100001100101011011000110110001101111',0],
            //        ........HHHHHHHHiiiiiiii!!!!!!!!
            [' Hi!', '00100000010010000110100100100001',0],
        ];
    }
    /**
     * @dataProvider decBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::basex_decode
     * @todo   Implement testBasex_decode().
     */
    public function testBasex_decode($dec, $bits)
    {
        $bc = $this->object;
        $res = $bc->basex_decode($dec, 10);
        $this->assertEquals($res, $dec);

        // test bad base
        $res = $bc->basex_decode("1231!", 58);
        $this->assertFalse($res);

        if ($dec) return;

        $base_def = $bc->base_default;

        $xto = $bc->basex_encode($dec, $base_def);
        $chk = $bc->basex_decode($xto);
        $this->assertEquals($dec, $chk);

        //try unknown base
        $chk = $bc->basex_decode($xto, 300);
        $this->assertFalse($chk);
    }

    /**
     * @dataProvider decBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::basex_encode
     * @todo   Implement testBasex_encode().
     */
    public function testBasex_encode($dec, $bits)
    {
        $bc = $this->object;
        if (!$dec) return;
        $chk = $bc->basex_encode($dec, 10);
        $this->assertEquals($dec, $chk);

        if ($dec>1) return;
        $chk = $bc->basex_encode($dec, 300);
        $this->assertFalse($chk);
    }

    /**
     * @dataProvider decHexB58Provider
     * @covers ierusalim\BaseConvert\BaseConvert::dectohex
     * @todo   Implement testDectohex().
     */
    public function testDectohex($dec, $hex, $b58)
    {
        $bc = $this->object;
        $chk = (\strlen($hex) % 2)  ? '0' . $hex : $hex;
        $res = $bc->dectohex($dec);
        $this->assertEquals($res, $chk);
        if (!$dec) {
            //489 iterations 00-ffff
            for($d=0; $d < 65536; $d++) {
                $res = $bc->dectohex($d);
                $hex = dechex($d);
                $chk = (\strlen($hex) % 2)  ? '0' . $hex : $hex;
                $this->assertEquals($res, $chk);
                if ($d > 16) $d+=15;
                if ($d > 256) $d+=127;
                if ($d > 1024) $d+ 1023;
            }
        }
    }

    /**
     * @dataProvider decHexB58Provider
     * @covers ierusalim\BaseConvert\BaseConvert::hextodec
     * @todo   Implement testHextodec().
     */
    public function testHextodec($dec, $hex, $b58)
    {
        $bc = $this->object;
        $chk = (\strlen($hex) % 2)  ? '0' . $hex : $hex;
        $res = $bc->hextodec($chk);
        //echo "$dec - $res = $chk\n";
        $this->assertEquals($res, $dec);
    }

    /**
     * @dataProvider decBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::dectobits
     * @todo   Implement testDectobits().
     */
    public function testDectobits($dec, $bits)
    {
        $bc = $this->object;
        $res = $bc->dectobits($dec);
        $this->assertEquals($res, $bits);
    }

    /**
     * @dataProvider decBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::bitstodec
     * @todo   Implement testBitstodec().
     */
    public function testBitstodec($dec, $bits)
    {
        $bc = $this->object;
        $res = $bc->bitstodec($bits);
        $this->assertEquals($res, $dec);
    }

    /**
     * @dataProvider hexBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::hextobits
     * @todo   Implement testHextobits().
     */
    public function testHextobits($hex, $bits)
    {
        $bc = $this->object;
        $res = $bc->hextobits($hex);
        $this->assertEquals($res, $bits);
    }

    /**
     * @dataProvider hexBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::hextobitsQuick
     * @todo   Implement testHextobitsQuick().
     */
    public function testHextobitsQuick($hex, $bits)
    {
        $bc = $this->object;
        $res = $bc->hextobitsQuick($hex, true);
        if ($res === '') $res = '0';
        $this->assertEquals($res, $bits);
    }

    public function testHextobitsSpeed()
    {
        $bc = $this->object;
        $hex = 'fffffffffffffffffffffffffffffffebaaedce6af48a03bbfd25e8cd0364141';
        $iter = 100;
        echo "\nSpeed compare test started:\n";

        $timestart = microtime(true);
        for($i = 0; $i < $iter; $i++) {
            $res = $bc->hextobits($hex);
        }
        $timeend = microtime(true) - $timestart;
        echo "$timeend s. -- hextobits\n";

        $timestart = microtime(true);
        for($i = 0; $i < $iter; $i++) {
            $res = $bc->hextobitsQuick($hex);
        }
        $timeend = microtime(true) - $timestart;
        echo "$timeend s. -- hextobitsQuick\n";

        echo "Speed compare test complete.\n";
    }

    /**
     * @dataProvider binBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::bytestobits
     * @todo   Implement testBytestobits().
     */
    public function testBytestobits($bin, $bits, $removeLeftZeros)
    {
        $bc = $this->object;
        $res = 'b' . $bc->bytestobits($bin, $removeLeftZeros);
        //echo "$bin => $res [$removeLeftZeros]\n";
        $this->assertEquals($res, 'b' . $bits);
    }

    /**
     * @dataProvider binBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::bitstobytes
     * @todo   Implement testBitstobytes().
     */
    public function testBitstoBytes($bytes, $bits, $leftRemove)
    {
        $bc = $this->object;
        $res = $bc->bitstobytes($bits);
        $this->assertEquals($res, $bytes);
    }

    /**
     * @dataProvider binBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::bitstohexQuick
     * @todo   Implement testBitstohexQuick().
     */
    public function testBitstohexQuick($bytes, $bits, $leftRemove)
    {
        $bc = $this->object;
        $res = $bc->bitstohexQuick($bits, true);
        $hex = bin2hex($bytes);
        $this->assertEquals($res, $hex);
    }

    /**
     * @dataProvider hexBitsProvider
     * @covers ierusalim\BaseConvert\BaseConvert::bitstohex
     * @todo   Implement testBitstohex().
     */
    public function testBitstohex($hex, $bits)
    {
        $bc = $this->object;
        $res = $bc->bitstohex($bits);
        $this->assertEquals($res, $hex);
    }

    /**
     * @dataProvider decHexB58Provider
     * @covers ierusalim\BaseConvert\BaseConvert::dectobase58
     * @todo   Implement testDectobase58().
     */
    public function testDectobase58($dec, $hex, $b58)
    {
        $bc = $this->object;
        $res = $bc->dectobase58($dec);
        $this->assertEquals($res, $b58);
    }

    /**
     * @dataProvider decHexB58Provider
     * @covers ierusalim\BaseConvert\BaseConvert::hextobase58
     * @todo   Implement testHextobase58().
     */
    public function testHextobase58($dec, $hex, $b58)
    {
        $bc = $this->object;
        $res = $bc->hextobase58($hex);
        $this->assertEquals($res, $b58);
    }

    /**
     * @dataProvider decHexB58Provider
     * @covers ierusalim\BaseConvert\BaseConvert::base58tohex
     * @todo   Implement testBase58tohex().
     */
    public function testBase58tohex($dec, $hex, $b58)
    {
        $bc = $this->object;
        $res = $bc->base58tohex($b58);
        $chk = (\strlen($hex) % 2)  ? '0' . $hex : $hex;
        $this->assertEquals($res, $chk);
    }
}
