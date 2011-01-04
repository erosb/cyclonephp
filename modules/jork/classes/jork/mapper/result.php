<?php
/**
 * An interface that abstracts an object that is able to map a row
 * of a database SELECT query result to anything that can be the result
 * of an object SELECT query (JORK query).
 *
 * @see JORK_Mapper_Entity
 * @see JORK_Mapper_Component
 * @see JORK_Mapper_Expression
 */

interface JORK_Mapper_Result {

    /**
     * Creates the object query result item
     *
     * @param array $row a row of the database query result
     */
    public function map_row(&$row);
    
}