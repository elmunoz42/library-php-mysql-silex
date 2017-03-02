<?php
    class Copies
    {
        private $shelf;
        private $checked_out;
        private $book_id;
        private $id;

        function __construct($shelf, $checked_out, $book_id, $id = null)
        {
            $this->shelf = $shelf;
            $this->checked_out = $checked_out;
            $this->book_id = $book_id;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getShelf()
        {
            return $this->shelf;
        }

        function setShelf($new_shelf)
        {
            $this->shelf = $new_shelf;
        }

        function getCheckedOut()
        {
            return $this->checked_out;
        }

        function setCheckedOut($new_checked_out)
        {
            $this->checked_out = $new_checked_out;
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
            $GLOBALS['DB']->exec("INSERT INTO copies (shelf, checked_out, book_id) VALUES ({$this->getShelf()}, {$this->getCheckedOut()}, {$this->getBookId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_shelf, $new_checked_out, $new_book_id)
        {
            $GLOBALS['DB']->exec("UPDATE copies SET shelf = {$new_shelf}, checked_out = {$new_checked_out}, book_id = {$new_book_id} WHERE id = {$this->getId()};");
            $this->setShelf($new_shelf);
            $this->setCheckedOut($new_checked_out);
            $this->setBookId($new_book_id);
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
                $shelf = $copy['shelf'];
                $checked_out = $copy['checked_out'];
                $book_id = $copy['book_id'];
                $id = $copy['id'];
                $new_copy = new Copies($shelf, $checked_out, $book_id, $id);
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
