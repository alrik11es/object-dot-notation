<?php
namespace Alr\ObjectDotNotation;

class Data
{
    private $data;
    private $tram = false;

    static public function load($mixed)
    {
        $d = new Data();
        $d->l($mixed);
        return $d;
    }

    public function l($mixed)
    {
        $this->data = json_decode(json_encode($mixed));
    }

    public function get($property)
    {
        $value = null;
        $values = explode('.', $property);
        $first_value = $values[0];

        if($this->tram){
            if(property_exists($this->tram, $first_value)){
                array_shift($values);
                $new_prop = implode('.', $values);
                $this->tram = $this->tram->$first_value;
                if(is_object($this->tram) || is_array($this->tram)){
                    $value = $this->get($new_prop);
                } else {
                    $value = $this->tram;
                    $this->tram = false;
                }
            }
        } else {
            if(property_exists($this->data, $first_value)){
                array_shift($values);
                $new_prop = implode('.', $values);
                $this->tram = $this->data->$first_value;
                $value = $this->get($new_prop);
            }
        }

        return $value;
    }
}