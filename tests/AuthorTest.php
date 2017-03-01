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

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Author::deleteAll();
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
    }
?>
