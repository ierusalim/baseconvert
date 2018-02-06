
# BaseConv

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
use ierusalim\BaseConverter;

$bc = new BaseConvert;

$hex = "43786437856abcdef";
$b58 = $bc->hextobase58($hex);

echo "hex:$hex => base58:$b58";
```
