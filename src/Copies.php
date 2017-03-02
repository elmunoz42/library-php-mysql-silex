<?php
    class Copies
    {
        private $available;
        private $book_id;
        private $id;

        function __construct($book_id, $id = null)
        {
            $this->available = true;
            $this->book_id = $book_id;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getAvailable()
        {
            return $this->available;
        }

        function setAvailable($new_available)
        {
            $this->available = $new_available;
        }

        function getBookId()
        {
            return $this->book_id;
        }

        function setBookId($new_book_id)
        {
            $this->book_id = $new_book_id;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO copies (book_id, available) VALUES ({$this->getBookId()}, {$this->getAvailable()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_available)
        {
            $GLOBALS['DB']->exec("UPDATE copies SET available = {$new_available} WHERE id = {$this->getId()};");
            $this->setAvailable($new_available);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $copies = [];

            foreach($returned_copies as $copy)
            {
                $available = $copy['available'];
                $book_id = $copy['book_id'];
                $id = $copy['id'];
                $new_copy = new Copies($book_id, $id);
                $new_copy->setAvailable($available);
                array_push($copies, $new_copy);
            }
            return $copies;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies;");
        }

        static function find($copy_id)
        {
            $copies = Copies::getAll();
            $found_copy = null;

            foreach($copies as $copy)
            {
                $id = $copy->getId();
                if ($id == $copy_id)
                {
                    $found_copy = $copy;
                }
            }

            return $found_copy;
        }
    }

?>
