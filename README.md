![alt tag](https://raw.githubusercontent.com/alrik11es/object-dot-notation/master/dot-library.png) [![Build Status](https://travis-ci.org/alrik11es/object-dot-notation.svg?branch=master)](https://travis-ci.org/alrik11es/object-dot-notation)

    The idea behind this library is to allow the access through
    `config.port` dot notation to object data.

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
**Note:** In PHP7 you can just use  `$var = $something ?? $something2;` but if you need to do this dynamically it becomes harder to do.

## Demo

[You can try a demo here](http://demo.dotnotation.net)

## Installation

Requires composer and PHP5.6+

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
echo $d->{'config.port'};
echo $d->config; // ['port'=>1234 ...]
```
### Array and array search

For other kind of uses you're gonna need to get a position of an array or search
and get the first value of array.

Take this object as example:
```json
{
    "config": [{
        "port": "80",
        "url": "aurl.com"
    },{
        "port": "90",
        "url": "burl.com"
    }]
}
```
You can use this way to access the information:
```php
<?php
$d = \Alr\ObjectDotNotation\Data::load($mixed);
echo $d->get('config[0].port'); // 80
echo $d->{'config[port=90|first].url'}; // burl.com
```

### Filters
You can use filters for the array selection process.

`[port=90|first]`

> IMPORTANT NOTE: Actually you can only use `|first` filter, use it always because it's going to be needed on future versions to avoid compatibility problems.

#### Advanced filters
***TODO***
