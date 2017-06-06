<?php
namespace Alr\ObjectDotNotation;

class Data
{
    private $data;
    private $part = false;

    /**
     * Load any object or array
     * @param $mixed
     * @return Data
     */
    static public function load($mixed)
    {
        $d = new Data();
        $d->l($mixed);
        return $d;
    }

    private function l($mixed)
    {
        $this->data = json_decode(json_encode($mixed));
    }

    /**
     * Obtain a specific property value
     * @param $property
     * @return bool|null
     */
    public function get($property)
    {
        $value = null;
        $values = explode('.', $property);
        $first_value = $values[0];

        if($this->part){
            if(is_object($this->part) && property_exists($this->part, $first_value)){
                array_shift($values);
                $new_prop = implode('.', $values);
                $this->part = $this->part->$first_value;
                if(is_object($this->part) || is_array($this->part)){
                    $value = $this->get($new_prop);
                } else {
                    $value = $this->part;
                    $this->part = false;
                }
            } else {
                $value = $this->part;
            }
        } else {
            if(property_exists($this->data, $first_value)){
                array_shift($values);
                $new_prop = implode('.', $values);
                $this->part = $this->data->$first_value;
                $value = $this->get($new_prop);
            }
        }

        return $value;
    }
}