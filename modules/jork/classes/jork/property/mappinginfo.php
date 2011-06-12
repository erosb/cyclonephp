<?php

/**
 * Value object used by JORK_Mapper_Entity::resolve_prop_chain().
 *
 * Represents the mapping information related to a non-atomic property.
 *
 */
class JORK_Property_MappingInfo {

    /**
     * The mapper that does the mapping of the property.
     *
     * @var JORK_Mapper_Entity
     */
    public $mapper;

    /**
     * The mapping schema of the property.
     *
     * @var JORK_Mapping_Schema
     */
    public $schema;

    /**
     * The name of the property (only the last item of the original property chain).
     * 
     * @var string
     */
    public $property_name;

    function __construct(JORK_Mapper_Entity $mapper, JORK_Mapping_Schema $schema
            , $property_name) {
        $this->mapper = $mapper;
        $this->schema = $schema;
        $this->property_name = $property_name;
    }

}