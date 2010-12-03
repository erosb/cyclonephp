<?php


class JORK_Naming_ServiceTest extends Kohana_Unittest_TestCase {

    public function testGetSchema() {
        $service = new JORK_Naming_Service;
        $service->set_alias('Model_User', 'user');
        $schema = $service->get_schema('user.posts');
        $this->assertEquals($schema, JORK_Model_Abstract::schema_by_class('Model_Post'));


        $service->set_alias('user.posts', 'post');
        $schema = $service->get_schema('post.topic');
        $this->assertEquals($schema, JORK_Model_Abstract::schema_by_class('Model_Topic'));

        $schema = $service->get_schema('post.topic.name');
        $this->assertEquals($schema, 'string');
    }

    public function testTableAlias() {
        $service = new JORK_Naming_Service;
        $service->set_alias('Model_Post', 'post');
        $service->set_alias('Model_Post', 'post2');
        $this->assertEquals('t_posts_0', $service->table_alias('post', 't_posts'));
        $this->assertEquals('t_posts_1', $service->table_alias('post', 't_posts'));
    }
}