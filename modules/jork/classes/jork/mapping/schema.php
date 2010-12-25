<?php


class JORK_Mapping_Schema {

    public $class;

    public $table;

    public $columns;

    public $components;

    public function primary_key() {
        foreach ($this->columns as $name => $def) {
            if (array_key_exists('primary', $def))
                return $name;
        }
    }

    public function get_property_schema($name) {
        foreach ($this->columns as $k => $v) {
            if ($k == $name)
                return $v;
        }
        foreach ($this->components as $k => $v) {
            if ($k == $name)
                return $v;
        }
        throw new JORK_Schema_Exception("property '$name' of {$this->class} does not exist");
    }
    
}