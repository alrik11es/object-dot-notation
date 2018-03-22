![alt tag](https://raw.githubusercontent.com/alrik11es/object-dot-notation/master/dot-library.png)

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

## Demo

[You can try a demo here](http://demo.dotnotation.net)

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
echo $d->{'config.port'};
echo $d->config; // ['port'=>1234 ...]
```
### Change validation behaviour

The default validation for every sub-request checks if is object and has any properties.

You can change the last row validation behaviour to check for specific result value. Like strings or whatever.

```php
<?php
$d->setValidation(function($data){
      return is_object($data);
  });
```