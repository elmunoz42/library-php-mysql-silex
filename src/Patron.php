<?php
    class Patron
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET name = '{$new_name}' WHERE id = {$this->getId()};");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = [];

            foreach($returned_patrons as $patron)
            {
                $name = $patron['name'];
                $id = $patron['id'];
                $new_patron = new Patron($name, $id);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

        static function find($patron_id)
        {
            $patrons = Patron::getAll();
            $found_patron = null;

            foreach($patrons as $patron)
            {
                $id = $patron->getId();
                if ($id == $patron_id)
                {
                    $found_patron = $patron;
                }
            }

            return $found_patron;
        }

        function checkoutCopy($copy)
        {
            $date = date('Y-m-d h:i:s');
            $GLOBALS['DB']->exec("INSERT INTO patrons_copies (copy_id, patron_id, checkout_date) VALUES ({$copy->getId()}, {$this->getId()},'{$date}');");
        }

        function booksEnrichingYourLife()
        {
            $books_enriching_your_life = $GLOBALS['DB']->query("SELECT books.* FROM
            patrons JOIN patrons_copies ON (patrons.id = patrons_copies.patron_id)
                    JOIN copies ON (patrons_copies.copy_id = copies.id)
                    JOIN books ON (copies.book_id = books.id )
                    WHERE patrons.id = {$this->getId()};");

            $books=array();
            foreach($books_enriching_your_life as $book)
            {
                $book_title = $book['title'];
                $book_id = $book['id'];
                $new_book = new Book($book_title, $book_id);
                array_push($books, $new_book);
            }
            return $books;
        }

    }

?>
