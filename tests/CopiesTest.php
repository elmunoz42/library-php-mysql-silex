<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    require_once 'src/Copies.php';
    require_once 'src/Book.php';

    class CopiesTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Copies::deleteAll();
            Book::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $shelf = 8;
            $checked_out = 0;
            $book_id = 3;
            $id = 32;
            $new_copies = new Copies($shelf, $checked_out, $book_id, $id);

            //Act
            $result = $new_copies->getId();

            //Assert
            $this->assertEquals(32, $result);

        }

        function test_getShelf()
        {
            //Arrange
            $shelf = 8;
            $checked_out = 0;
            $book_id = 3;
            $new_copies = new Copies($shelf, $checked_out, $book_id);

            //Act
            $result = $new_copies->getShelf();

            //Assert
            $this->assertEquals(8, $result);
        }

        function test_setShelf()
        {
            //Arrange
            $shelf = 8;
            $new_shelf = 4;
            $checked_out = 0;
            $book_id = 3;
            $new_copies = new Copies($shelf, $checked_out, $book_id);

            //Act
            $new_copies->setShelf($new_shelf);
            $result = $new_copies->getShelf();

            //Assert
            $this->assertEquals(4, $result);
        }

        function test_save()
        {
            //Arrange
            $shelf = 8;
            $checked_out = 0;
            $book_id = 3;
            $new_copies = new Copies($shelf, $checked_out, $book_id);
            $new_copies->save();

            //Act
            $result = Copies::getAll();

            //Assert
            $this->assertEquals([$new_copies], $result);
        }

        function test_getAll()
        {
            //Arrange
            $shelf = 8;
            $checked_out = 0;
            $book_id = 3;
            $new_copies = new Copies($shelf, $checked_out, $book_id);
            $new_copies->save();

            $shelf2 = 4;
            $checked_out2 = 4;
            $book_id2 = 4;
            $new_copies2 = new Copies($shelf2, $checked_out2, $book_id2);
            $new_copies2->save();

            $shelf3 = 0;
            $checked_out3 = 7;
            $book_id3 = 6;
            $new_copies3 = new Copies($shelf3, $checked_out3, $book_id3);
            $new_copies3->save();

            //Act
            $result = Copies::getAll();

            //Assert
            $this->assertEquals([$new_copies, $new_copies2, $new_copies3], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $shelf = 8;
            $checked_out = 0;
            $book_id = 3;
            $new_copies = new Copies($shelf, $checked_out, $book_id);
            $new_copies->save();

            $shelf2 = 4;
            $checked_out2 = 4;
            $book_id2 = 4;
            $new_copies2 = new Copies($shelf2, $checked_out2, $book_id2);
            $new_copies2->save();

            $shelf3 = 0;
            $checked_out3 = 7;
            $book_id3 = 6;
            $new_copies3 = new Copies($shelf3, $checked_out3, $book_id3);
            $new_copies3->save();

            //Act
            Copies::deleteAll();
            $result = Copies::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $shelf = 8;
            $checked_out = 0;
            $book_id = 3;
            $new_copies = new Copies($shelf, $checked_out, $book_id);
            $new_copies->save();

            $shelf2 = 4;
            $checked_out2 = 4;
            $book_id2 = 4;
            $new_copies2 = new Copies($shelf2, $checked_out2, $book_id2);
            $new_copies2->save();

            $shelf3 = 0;
            $checked_out3 = 7;
            $book_id3 = 6;
            $new_copies3 = new Copies($shelf3, $checked_out3, $book_id3);
            $new_copies3->save();

            //Act
            $result = Copies::find($new_copies2->getId());

            //Assert
            $this->assertEquals($new_copies2, $result);
        }

        function test_delete()
        {
            //Arrange
            $shelf = 8;
            $checked_out = 0;
            $book_id = 3;
            $new_copies = new Copies($shelf, $checked_out, $book_id);
            $new_copies->save();

            $shelf2 = 4;
            $checked_out2 = 4;
            $book_id2 = 4;
            $new_copies2 = new Copies($shelf2, $checked_out2, $book_id2);
            $new_copies2->save();

            $shelf3 = 0;
            $checked_out3 = 7;
            $book_id3 = 6;
            $new_copies3 = new Copies($shelf3, $checked_out3, $book_id3);
            $new_copies3->save();

            //Act
            $new_copies2->delete();
            $result = Copies::getAll();

            //Assert
            $this->assertEquals([$new_copies, $new_copies3], $result);
        }

        // function test_update()
        // {
        //     //Arrange
        //     $shelf = 8;
        //     $new_shelf = 4;
        //
        //     $checked_out = 0;
        //     $new_checked_out = 4;
        //
        //     $book_id = 3;
        //     $new_book_id = 3;
        //
        //     $new_copies = new Copies($shelf, $checked_out, $book_id);
        //     $new_copies->save();
        //
        //     //Act
        //     $new_copies->update($new_shelf, $new_checked_out, $new_book_id);
        //     $updated_copies = Copies::find($new_copies->getId());
        //     $result = $updated_copies->getShelf();
        //
        //     //Assert
        //     $this->assertEquals(4, $result);
        // }
    }
?>
