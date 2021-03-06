<?php


class JORK_Model_Collection_ManyToManyTest extends JORK_DbTest {

    public function testAppend() {
        $topic = new Model_Topic;
        $category = new Model_Category;
        $category->id = 3;
        $topic->categories->append($category);
        $this->assertEquals(1, count($topic->categories));
        $this->assertEquals($topic->categories[3], $category);
    }

    public function testDelete() {
        $topic = new Model_Topic;
        $category = new Model_Category;
        $category->id = 3;
        $topic->categories->append($category);
        $this->assertEquals(1, count($topic->categories));

        $topic->categories->delete($category);
        $this->assertEquals(0, count($topic->categories));
    }

    public function testSave() {
        $result = JORK::from('Model_Topic')->with('categories')
                ->where('id', '=', DB::esc(2))->exec('jork_test');
        $topic = $result[0];
        $this->assertInstanceOf('Model_Topic', $topic);
        
        $result = JORK::from('Model_Category')->where('id', '=', DB::esc(3))->exec('jork_test');
        $category = $result[0];
        $this->assertInstanceOf('Model_Category', $category);

        $topic->categories->append($category);
        unset($topic->categories[2]);
        $topic->save();
        $result = DB::select()->from('categories_topics')
                ->where('topic_fk', '=', DB::esc(2))->exec('jork_test')->as_array();
        $this->assertEquals(1, count($result));
        $this->assertEquals(3, $result[0]['category_fk']);
        $this->assertEquals(4, count(DB::select()->from('categories_topics')
                ->exec('jork_test')->as_array()));
    }
}