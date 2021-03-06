<?php


class JORK_Query_Test extends Kohana_Unittest_TestCase {

    /**
     * @expectedException JORK_Syntax_Exception
     */
    public function testSelect() {
        $query = new JORK_Query_Select;
        $query->select('user{id,name} u', 'user', 'user{id,name}', 'user.posts posts');
        $this->assertEquals($query->select_list, array(
            array(
                'prop_chain' => JORK_Query_PropChain::from_string('user'),
                'projection' => array('id', 'name'),
                'alias' => 'u'
            ),
            array(
                'prop_chain' => JORK_Query_PropChain::from_string('user')
            ),
            array(
                'prop_chain' => JORK_Query_PropChain::from_string('user'),
                'projection' => array('id', 'name')
            ),
            array(
                'prop_chain' => JORK_Query_PropChain::from_string('user.posts'),
                'alias' => 'posts'
            )
        ));
        $query->select('asdasd x sad');
    }

    public function testFrom() {
        $query = new JORK_Query_Select;
        $query->from('Model_User u');
        $query->from('Model_User');
        $this->assertEquals($query->from_list, array(
            array(
                'class' => 'Model_User',
                'alias' => 'u'
            ),
            array(
                'class' => 'Model_User'
            )
        ));
    }

    public function testWith() {
        $query = new JORK_Query_Select;
        $subquery = new JORK_Query_Select;
        $query->with('post.author', 'post.author auth', $subquery);
        $this->assertEquals($query->with_list, new ArrayObject(array(
            array(
                'prop_chain' => JORK_Query_PropChain::from_string('post.author')
            ),
            array(
                'prop_chain' => JORK_Query_PropChain::from_string('post.author'),
                'alias' => 'auth'
            ),
            $subquery
        )));
    }

    public function testJoin() {
        $query = new JORK_Query_Select;
        $subselect = new JORK_Query_Select();
        $query->join('Model_User u')->on('u.id', '=', 'post.author_fk');
        $query->join('Model_User')->on('exists', $subselect);
        //$query->join('Model_User')->on(JORK::expr)
        $this->assertEquals($query->join_list, new ArrayObject(array(
            array(
                'type' => 'INNER',
                'class' => 'Model_User',
                'alias' => 'u',
                'condition' => array('u.id', '=', 'post.author_fk')
            ),
            array(
                'type' => 'INNER',
                'class' => 'Model_User',
                'condition' => array('exists', $subselect)
            )
        )));
    }

    public function testWhere() {
        $query = new JORK_Query_Select;
        $query->where(1, 2, 3);
        $this->assertEquals($query->where_conditions, array(new DB_Expression_Binary(1, 2, 3)));
    }
}