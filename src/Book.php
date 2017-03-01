<?php
    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function getTitle()
        {
            return $this->title;
        }

        function setTitle($new_title)
        {
            $this->title = $new_title;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO books (title) VALUES ('{$this->getTitle()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM books WHERE id = {$this->getId()};");
        }

        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = [];

            foreach($returned_books as $book)
            {
                $title = $book['title'];
                $id = $book['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books;");
        }

        static function find($book_id)
        {
            $books = Book::getAll();
            $found_book = null;

            foreach($books as $book)
            {
                $id = $book->getId();
                if ($id == $book_id)
                {
                    $found_book = $book;
                }
            }

            return $found_book;
        }
    }

?>
