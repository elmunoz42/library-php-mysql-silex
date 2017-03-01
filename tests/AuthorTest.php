<?php
    require_once 'src/Author.php';

    class AuthorTest extends PHPUnit_Framework_TestCase
    {
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
    }
?>
