<?php


class JORK_Test extends Kohana_Unittest_TestCase {

    public function testBasicSelect() {
        $query = JORK::from('Model_User');
        $this->assertTrue($query instanceof  JORK_Query_Select);
    }

    public function testSelect() {
        $query = JORK::from(array('Model_User', 'user'))
            ->join(array('user.posts', 'post'))
            ->join(array('post.topic', 'topic'))
            ->join(array('topic.categories', 'categories'))
                ;
    }

    public function testSimpleSelect() {
        $result = JORK::from('Model_User user')->exec();
        $this->assertTrue($result instanceof JORK_Query_Result);
        foreach ($result as $user) {
            $this->assertTrue($user instanceof Model_User);
        }
    }
}