<?php
namespace Alr\ObjectDotNotation;

class Data
{
    private $data;
    private $parts;
    private $result;

    /**
     * Load any object or array
     * @param $mixed
     * @return Data
     */
    static public function load($mixed)
    {
        $d = new Data();
        return $d->l($mixed);
    }

    private function l($mixed)
    {
        $this->data = json_decode(json_encode($mixed)); // Convert dump to object no matter what it is.
        return $this;
    }

    /**
     * Obtain a specific property value
     * @param $property
     * @return bool|null
     */
    public function get($property)
    {
        $value = null;

        $this->parseDotNotation($property);

        $this->result = $this->data;

        foreach($this->parts as $part){
            $this->result = $this->getPart($part);
            if(is_null($this->result)) break;
        }

        return $this->result;
    }

    private function getPart($part)
    {
        $result = null;
        if(is_object($this->result) && property_exists($this->result, $part)) {
            $result = $this->result->$part;
        }
        return $result;
    }

    private function parseDotNotation($property)
    {
        $values = explode('.', $property);
        $this->parts = $values;
    }

    public function __get($name)
    {
        return $this->get($name);
    }
}