<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Author.php';
    require_once __DIR__.'/../src/Book.php';
    require_once __DIR__.'/../src/Copies.php';
    require_once __DIR__.'/../src/Patron.php';

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    session_start();
    if (empty($_SESSION['user']))
    {
            $_SESSION['user'] = null;
    }

    $server = 'mysql:host=localhost:8889;dbname=library';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get('/', function() use($app) {

        return $app['twig']->render('index.html.twig');
    });

    $app->get('/main', function() use($app) {
        if ($_GET)
        {
            $_SESSION['user'] = $_GET['user'];
        }

        return $app['twig']->render('main.html.twig', array('books' => Book::getAll(), 'user' => $_SESSION['user']));
    });

    $app->post('/add-book', function() use($app) {
        $new_book = new Book($_POST['title']);
        $new_book->save();
        for ($index = 0; $index < $_POST['copies']; $index++)
        {
            $copies = new Copies($new_book->getId());
            $copies->save();
        }
        $new_author = new Author($_POST['author']);
        $new_author->save();
        $new_book->addAuthor($new_author);

        return $app->redirect('/main');
    });
    // View book
    $app->get('/book/{id}', function($id) use($app) {

        $book = Book::find($id);
        $copies_available = $book->findAvailableCopies();

        return $app['twig']->render('book.html.twig', array('book' => $book, 'copies_available' => $copies_available));
    });

    return $app;
?>
