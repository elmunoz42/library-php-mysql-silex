<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    require_once 'src/Patron.php';

    class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Patron::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = 'Philip Putnam';
            $id = 32;
            $new_patron = new Patron($name, $id);

            //Act
            $result = $new_patron->getId();

            //Assert
            $this->assertEquals(32, $result);

        }

        function test_getName()
        {
            //Arrange
            $name = 'Philip Putnam';
            $new_patron = new Patron($name);

            //Act
            $result = $new_patron->getName();

            //Assert
            $this->assertEquals('Philip Putnam', $result);
        }

        function test_setName()
        {
            //Arrange
            $name = 'Philip Putnam';
            $new_name = 'Phil Pootman';
            $new_patron = new Patron($name);

            //Act
            $new_patron->setName($new_name);
            $result = $new_patron->getName();

            //Assert
            $this->assertEquals('Phil Pootman', $result);
        }

        function test_save()
        {
            //Arrange
            $name = 'Philip Putnam';
            $new_patron = new Patron($name);
            $new_patron->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$new_patron], $result);
        }

        function test_getAll()
        {
            //Arrange
            $name = 'Philip Putnam';
            $new_patron = new Patron($name);
            $new_patron->save();

            $name2 = 'Robert Smith';
            $new_patron2 = new Patron($name2);
            $new_patron2->save();

            $name3 = 'Gwen Doe';
            $new_patron3 = new Patron($name3);
            $new_patron3->save();

            //Act
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$new_patron, $new_patron2, $new_patron3], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = 'Philip Putnam';
            $new_patron = new Patron($name);
            $new_patron->save();

            $name2 = 'Robert Smith';
            $new_patron2 = new Patron($name2);
            $new_patron2->save();

            $name3 = 'Gwen Doe';
            $new_patron3 = new Patron($name3);
            $new_patron3->save();

            //Act
            Patron::deleteAll();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = 'Philip Putnam';
            $new_patron = new Patron($name);
            $new_patron->save();

            $name2 = 'Robert Smith';
            $new_patron2 = new Patron($name2);
            $new_patron2->save();

            $name3 = 'Gwen Doe';
            $new_patron3 = new Patron($name3);
            $new_patron3->save();

            //Act
            $result = Patron::find($new_patron2->getId());

            //Assert
            $this->assertEquals($new_patron2, $result);
        }

        function test_delete()
        {
            //Arrange
            $name = 'Philip Putnam';
            $new_patron = new Patron($name);
            $new_patron->save();

            $name2 = 'Robert Smith';
            $new_patron2 = new Patron($name2);
            $new_patron2->save();

            $name3 = 'Gwen Doe';
            $new_patron3 = new Patron($name3);
            $new_patron3->save();

            //Act
            $new_patron2->delete();
            $result = Patron::getAll();

            //Assert
            $this->assertEquals([$new_patron, $new_patron3], $result);
        }

        function test_update()
        {
            //Arrange
            $name = 'Philip Putnam';
            $new_name = "Phil Pootman";
            $new_patron = new Patron($name);
            $new_patron->save();

            //Act
            $new_patron->update($new_name);
            $updated_patron = Patron::find($new_patron->getId());
            $result = $updated_patron->getName();

            //Assert
            $this->assertEquals('Phil Pootman', $result);
        }
    }
?>
