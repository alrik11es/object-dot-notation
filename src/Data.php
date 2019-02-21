<?php

namespace Alr\ObjectDotNotation;

class Data
{
    private $data;
    private $parts;
    private $result;
    private $validation;

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
    public function get($property, callable $validation = null)
    {
        if ($validation) $this->validation = $validation;
        $value = null;

        $this->parseDotNotation($property);

        $this->result = $this->data;

        foreach ($this->parts as $part) {
            $this->result = $this->getPart($part);
            if (is_null($this->result)) break;
        }

        if ($this->validation) {
            $result = call_user_func($this->validation, $this->result);
        } else {
            $result = $this->result;
        }
        return $result;
    }

    public function setValidation(callable $validation)
    {
        $this->validation = $validation;
    }

    /**
     * Obtains a part of the mixed element or null
     * @param string $part
     * @return mixed|null
     */
    private function getPart($part)
    {
        $result = null;

        $array_part = preg_replace('/.*\[(.*)\]/', '$1', $part);
        $filters = explode('|',$array_part);
        $array_part = $filters[0]; // Temporary fix for future filters, now only first row will be returned

        $part = preg_replace('/\[.*\]/', '', $part);

        if (is_object($this->result) && property_exists($this->result, $part)) {
            if (preg_match('/\=/', $array_part)) {
                list($name, $value) = explode('=', $array_part);
                foreach ($this->result->$part as $key => $item) {
                    $d = self::load($item);
                    if ($d->get($name) == $value) {
                        $result = $item;
                        break;
                    }
                }
            } elseif ($array_part != $part && is_array($this->result->$part)) {
                if (ctype_digit($array_part)) {
                    $array = $this->result->$part; // 5.6 compatibility issue
                    $result = $array[$array_part];
                }
            } else {
                $result = $this->result->$part;
            }
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
