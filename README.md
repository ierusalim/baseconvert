
# BaseConvert
[![Build Status](https://api.travis-ci.org/ierusalim/baseconvert.svg?branch=master)](https://www.travis-ci.org/ierusalim/baseconvert)

Convertation from/to any user-defined base-chars-string throught decimal representation of arbitrary precision.

## Installation

File BaseConvert.php may be use independent.

For [composer](https://getcomposer.org/):

```
composer require ierusalim/baseconvert
````

## Usage BaseConvert


Create instance of BaseConvert class and define own base-characters string (if need).

No need to define new alphabet for use hex/binary/base58(bitcoin compatible).

```php
use ierusalim\BaseConvert;

$bc = new BaseConvert;

$hex = "43786437856abcdef";
$b58 = $bc->hextobase58($hex);

echo "$hex => base58: $b58";
```

## Functions

- -> dectohex($dec) -- Convert from decimal (012345679-base) to hex (0123456789abcdef-base)
- -> hextodec($hex) -- Convert from hex (0123456789abcdef-base) to decimal (012345679-base)
- -> dectobits($dec) -- Convert from decimal (012345679-base) to string of bits (01-base)
- -> bitstodec($bits) -- Convert from bits to decimal representation of arbitrary precision
- -> hextobits($hex) -- Convert from hex (0123456789abcdef-base) to bits string (01-base)
- -> bitstohex($bits) -- Convert from bits (01-base) to hex (0123456789abcdef-base)
- -> dectobase58($dec) -- Convert from decimal (012345679-base) to base58
- -> hextobase58($hex) -- Convert from hex (0123456789abcdef-base) to base58
- -> base58tohex($b58) -- Convert from base58 to hex (0123456789abcdef-base)
- -> basex_decode($data, $base_id) -- Convert from arbitrary base to decimal
- -> basex_encode($dec, $base_id) -- Convert from decimal to arbitrary base


## Usage vc85

vc85 is a one of many base85-algorithms, like ascii85, z85, etc.

Encoding vc85 has the following features:
- Each character is visually unique and easily recognizable:
  0123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyzзгджилпфцчшюяБГДЖИЛПФЦЧШЮЯ
- Encoded result does not contain special characters;
- encoding and decoding runs fast.

```php
use ierusalim\BaseConvert;

$bc = new vc85();

$str = "One day I'm gonna fly away One day when heavens calls my name";
$enc = $bc->vc85_encode($str);

echo "result: $enc \n";

// result: RkШжцYNQлAPjhWЮZLжz9XJZEЯeФ3nVXTБЮДbgГЧ3XTБЯVZnЯ67ZnЮtЦYrЯpJXФШGБd0BUdAbЮu81G

$back = $bc->vc85_decode($enc);

echo ($str === $back) ? "OK" : "Fail";
```

## Functions vc85

- -> vc85_encode($str) -- Convert from binary data to vc85
- -> vc85_decode($str) -- Convert from vc85 to binary data

## Functions base6400
- -> base6400_encode($str) -- Convert from binary to base6400
- -> base6400_decode($str) -- Convert from base6400 to binary
- -> explodeToUnicode($str) -- Convert string from utf-8 to Unicode-array
- -> implodeUnicode($arr) -- Convert Unicode-array to utf-8 string

## Bases (pre-defined base_id)

```php
    public $bases = [
        2 => '01',
        3 => '012',
        4 => '0123',
        8 => '01234567',
        10 => '0123456789',
        16 => '0123456789abcdef',
        58 => '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz',
    ];
```
