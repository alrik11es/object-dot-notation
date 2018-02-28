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

    /**
     * Used to load the mixed to object.
     * @param mixed $mixed
     * @return $this
     */
    private function l($mixed)
    {
        $this->data = json_decode(json_encode($mixed)); // Convert dump to object no matter what it is.
        return $this;
    }

    /**
     * Obtain a specific property value
     * @param $property
     * @return mixed|null
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

    /**
     * Obtains a part of the mixed element or null
     * @param string $part
     * @return mixed|null
     */
    private function getPart($part)
    {
        $result = null;
        if(is_object($this->result) && property_exists($this->result, $part)) {
            $result = $this->result->$part;
        }
        return $result;
    }

    /**
     * Simple parser for object dot notation element accessor. It will fill the parts property with values.
     * @param string $property
     */
    private function parseDotNotation($property)
    {
        $values = explode('.', $property);
        $this->parts = $values;
    }

    /**
     * This will allow you to get data like $d->{'config.port'}; or $d->config;
     * passing all the respective checks.
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->get($name);
    }
}