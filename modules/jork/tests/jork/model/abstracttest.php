<?php


class JORK_Model_AbstractTest extends JORK_DbTest {

    public function testInst() {
        Model_User::inst();
    }

    public function testManyToOneFK() {
        $post = new Model_Post;
        $topic = new Model_Topic;
        $topic->id = 10;
        $post->topic = $topic;
        $this->assertEquals(10, $post->topic_fk);
    }

    public function testManyToOneReverseFK() {
        $post = new Model_Post;
        $user = new Model_User;
        $user->id = 6;
        $post->author = $user;
        $this->assertEquals($post->user_fk, 6);
    }

    public function testOneToOneFK() {
        $category = new Model_Category;
        $user = new Model_User;
        $user->id = 5;
        $category->moderator = $user;
        $this->assertEquals(5, $category->moderator_fk);
    }

    public function testOneToOneReverseFK() {
        $category = new Model_Category;
        $user = new Model_User;
        $user->id = 3;
        $user->moderated_category = $category;
        $this->assertEquals($category->moderator_fk, 3);
    }

    public function testOneToManyFK() {
        $user = new Model_User;
        $user->id = 34;
        $post = new Model_Post;
        //$this->markTestSkipped('not yet implemented');
        $user->posts->append($post);
        $this->assertEquals($post->user_fk, 34);
    }

    public function testOneToManyReverseFK() {
        $topic = new Model_Topic;
        $topic->id = 2;
        $post = new Model_Post;
        //$this->markTestSkipped('not yet implemented');
        $topic->posts->append($post);
        $this->assertEquals(2, $post->topic_fk);
    }

    public function testPk() {
        $user = new Model_User();
        $user->id = 5;
        $this->assertEquals(5, $user->pk());
    }

    public function testSimpleSave() {
        $user = new Model_User;
        $user->name = 'foo bar';
        $user->save();
        $this->assertEquals(5, $user->id);
        $result = JORK::from('Model_User')->where('id', '=', DB::esc(5))
                ->exec('jork_test');
        foreach ($result as $user) {
            $this->assertEquals(5, $user->id);
            $this->assertEquals('foo bar', $user->name);
        }
    }

    public function testFKOneToManyUpdateOnSave() {
        $user = new Model_User;
        $post = new Model_Post;
        $user->posts->append($post);
        $user->name = 'foo bar';
        $user->save();
        $this->assertEquals(5, $user->id);
        $this->assertEquals(5, $post->user_fk);
    }

    public function testFKManyToOneReverseUpdateOnSave() {
        $topic = new Model_Topic;
        $topic->name = 'foo bar';
        $post = new Model_Post;
        $topic->posts->append($post);
        
        $topic->save();
        $this->assertEquals(5, $topic->id);
        $this->assertEquals(5, $post->topic_fk);
    }

    public function testUpdate() {
        $user = new Model_User;
        $user->id = 4;
        $user->name = 'foo';

        $post = new Model_Post;

        $user->posts->append($post);

        $user->save();

        $result = DB::select()->from('t_users')->where('id', '=', DB::esc(4))->exec('jork_test');
        foreach ($result as $row) {
            $this->assertEquals('foo', $row['name']);
        }

        $result = DB::select()->from('t_posts')->where('id', '=', DB::esc(5))->exec('jork_test');
        $this->assertEquals(1, count($result));
    }
}