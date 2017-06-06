# object-dot-notation library

![Status](https://travis-ci.org/alrik11es/object-dot-notation.svg?branch=master)

The idea behind this library is to allow the access through `config.port` dot notation to object data.

## Installation

Requires composer and PHP7.0+

> $ composer require alrik11es/object-dot-notation

## Usage

Simple usage:

Take this object as example:
```json
{
    "config": {
        "port": "1234",
        "url": "testurl.com"
    }
}
```
Then:
```php
$d = \Alr\ObjectDotNotation\Data::load($mixed);
echo $d->get('config.port'); // 1234
```