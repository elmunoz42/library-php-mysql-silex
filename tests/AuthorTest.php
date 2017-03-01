<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    require_once 'src/Author.php';
    require_once 'src/Book.php';

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
            Book::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $id = 32;
            $george = new Author($name, $id);

            //Act
            $result = $george->getId();

            //Assert
            $this->assertEquals(32, $result);

        }

        function test_getName()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $george = new Author($name);

            //Act
            $result = $george->getName();

            //Assert
            $this->assertEquals('George R. R. Martin', $result);
        }

        function test_setName()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $new_name = 'George Martin';
            $george = new Author($name);

            //Act
            $george->setName($new_name);
            $result = $george->getName();

            //Assert
            $this->assertEquals('George Martin', $result);
        }

        function test_save()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $george = new Author($name);
            $george->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$george], $result);
        }

        function test_getAll()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $george = new Author($name);
            $george->save();

            $name2 = 'Stephen King';
            $stephen = new Author($name2);
            $stephen->save();

            $name3 = 'Patrick Rufus';
            $patrick = new Author($name3);
            $patrick->save();

            //Act
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$george, $stephen, $patrick], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $george = new Author($name);
            $george->save();

            $name2 = 'Stephen King';
            $stephen = new Author($name2);
            $stephen->save();

            $name3 = 'Patrick Rufus';
            $patrick = new Author($name3);
            $patrick->save();

            //Act
            Author::deleteAll();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $george = new Author($name);
            $george->save();

            $name2 = 'Stephen King';
            $stephen = new Author($name2);
            $stephen->save();

            $name3 = 'Patrick Rufus';
            $patrick = new Author($name3);
            $patrick->save();

            //Act
            $result = Author::find($stephen->getId());

            //Assert
            $this->assertEquals($stephen, $result);
        }

        function test_delete()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $george = new Author($name);
            $george->save();

            $name2 = 'Stephen King';
            $stephen = new Author($name2);
            $stephen->save();

            $name3 = 'Patrick Rufus';
            $patrick = new Author($name3);
            $patrick->save();

            //Act
            $stephen->delete();
            $result = Author::getAll();

            //Assert
            $this->assertEquals([$george, $patrick], $result);
        }

        function test_addBook()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $george = new Author($name);
            $george->save();

            $title = 'A Game of Thrones';
            $new_book = new Book($title);
            $new_book->save();

            //Act
            $george->addBook($new_book);
            $result = $george->findBooks();

            //Assert
            $this->assertEquals([$new_book], $result);
        }

        function test_findBooks()
        {
            //Arrange
            $name = 'George R. R. Martin';
            $george = new Author($name);
            $george->save();

            $title = 'A Game of Thrones';
            $new_book = new Book($title);
            $new_book->save();

            $title2 = 'A Feast of Crows';
            $new_book2 = new Book($title2);
            $new_book2->save();

            $title3 = 'Dance with Dragons';
            $new_book3 = new Book($title3);
            $new_book3->save();

            //Act
            $george->addBook($new_book);
            $george->addBook($new_book2);
            $george->addBook($new_book3);
            $result = $george->findBooks();

            //Assert
            $this->assertEquals([$new_book, $new_book2, $new_book3], $result);
        }
    }
?>
