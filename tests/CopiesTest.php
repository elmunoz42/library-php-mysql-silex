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
            $book_id = 3;
            $id = 32;
            $new_copies = new Copies($book_id, $id);

            //Act
            $result = $new_copies->getId();

            //Assert
            $this->assertEquals(32, $result);

        }

        function test_getAvailable()
        {
            //Arrange
            $book_id = 3;
            $new_copies = new Copies($book_id);

            //Act
            $result = $new_copies->getAvailable();

            //Assert
            $this->assertEquals(true, $result);
        }

        function test_setAvailable()
        {
            //Arrange
            $book_id = 3;
            $new_copies = new Copies($book_id);

            //Act
            $new_copies->setAvailable(false);
            $result = $new_copies->getAvailable();

            //Assert
            $this->assertEquals(false, $result);
        }

        function test_save()
        {
            //Arrange
            $book_id = 3;
            $new_copies = new Copies($book_id);
            $new_copies->save();

            //Act
            $result = Copies::getAll();

            //Assert
            $this->assertEquals([$new_copies], $result);
        }

        function test_getAll()
        {
            //Arrange
            $book_id = 3;
            $new_copies = new Copies($book_id);
            $new_copies->save();

            $book_id2 = 4;
            $new_copies2 = new Copies($book_id2);
            $new_copies2->save();

            //Act
            $result = Copies::getAll();

            //Assert
            $this->assertEquals([$new_copies, $new_copies2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $book_id = 3;
            $new_copies = new Copies($book_id);
            $new_copies->save();

            $book_id2 = 4;
            $new_copies2 = new Copies($book_id2);
            $new_copies2->save();

            //Act
            Copies::deleteAll();
            $result = Copies::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $book_id = 3;
            $new_copies = new Copies($book_id);
            $new_copies->save();

            $book_id2 = 4;
            $new_copies2 = new Copies($book_id2);
            $new_copies2->save();


            //Act
            $result = Copies::find($new_copies2->getId());

            //Assert
            $this->assertEquals($new_copies2, $result);
        }

        function test_delete()
        {
            //Arrange
            $book_id = 3;
            $new_copies = new Copies($book_id);
            $new_copies->save();

            $book_id2 = 4;
            $new_copies2 = new Copies($book_id2);
            $new_copies2->save();


            //Act
            $new_copies->delete();
            $result = Copies::getAll();

            //Assert
            $this->assertEquals([$new_copies2], $result);
        }

        function test_update()
        {
            //Arrange
            $book_id = 3;
            $new_copies = new Copies($book_id);
            $new_copies->save();

            $book_id2 = 4;
            $new_copies2 = new Copies($book_id2);
            $new_copies2->save();

            //Act
            $new_copies->update(0);
            $updated_copies = Copies::find($new_copies->getId());
            $result = $updated_copies->getAvailable();

            //Assert
            $this->assertEquals(0, $result);
        }
    }
?>
