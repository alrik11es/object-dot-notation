# object-dot-notation library

![Status](https://travis-ci.org/alrik11es/object-dot-notation.svg?branch=master)

The idea behind this library is to allow the access through `config.port` dot notation to object data.

### Why?
My main problem was when accessing API data.
```json
{
    "hits":{
        "products": [
            {
                "name": "Shoe"
            }
        ]
    }
}
```
Imagine this is the result from an API. Usually to be sure that the data is what I want I'm gonna need to do:
```php
<?php
$result = r(); // imagine this is the result from an API with the json message abobe
if(is_object($result) && property_exists($result, 'hits')){
    if(is_object($result->hits) && property_exists($result->hits, 'products')){
        $whatiwant = $result->hits->products;
    }
}
```
This is really time consuming. I just needed a way to do something like:
```php
<?php
$d = \Alr\ObjectDotNotation\Data::load(r());
$whatiwant = $d->get('hits.products');
```

## Installation

Requires composer and PHP7.0+

> $ composer require alrik11es/object-dot-notation

## Usage

When the property is not found a `null` will be returned.

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
<?php
$d = \Alr\ObjectDotNotation\Data::load($mixed);
echo $d->get('config.port'); // 1234
```