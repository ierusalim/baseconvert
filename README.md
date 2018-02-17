
# BaseConvert

Convertation from/to any user-defined base-chars-string throught decimal representation of arbitrary precision.

## Installation

File BaseConvert.php may be use independent.

For [composer](https://getcomposer.org/):

```
composer require ierusalim/baseconv
````

## Usage

Create instance of BaseConvert class and define own base-characters string (if need).

No need to define new alphabet for use hex/binary/base58(bitcoin compatible).

```php
use ierusalim\BaseConvert;

$bc = new BaseConvert;

$hex = "43786437856abcdef";
$b58 = $bc->hextobase58($hex);

echo "hex:$hex => base58:$b58";
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
