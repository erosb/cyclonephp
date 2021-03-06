<?php


abstract class SimpleDB_Postgres_DbTest extends Kohana_Unittest_TestCase {

    public function setUp() {
        try {
            $sql = file_get_contents(MODPATH . 'simpledb/tests/pg_test.sql');
            DB::query($sql)->exec('postgres');
        } catch (DB_Exception $ex) {
            error_log($ex->getMessage());
            $this->markTestSkipped();
        }
    }

    
    
}