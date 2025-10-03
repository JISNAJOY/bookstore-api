<?php

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/vendor/autoload.php';

// Load .env variables
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');

// Boot Symfony kernel
$kernel = new \App\Kernel('dev', true);
$kernel->boot();

/** @var EntityManagerInterface $em */
$em = $kernel->getContainer()->get('doctrine')->getManager();

// Demo books array
$books = [
    ["Clean Code", "Robert C. Martin", 2008, 29.99],
    ["The Pragmatic Programmer", "Andrew Hunt", 1999, 39.99],
    ["Python Crash Course", "Eric Matthes", 2019, 25.99],
    ["Effective Java", "Joshua Bloch", 2018, 45.50],
    ["Design Patterns", "Erich Gamma", 1994, 49.99],
];

// Insert books
foreach ($books as $data) {
    $book = new Book();
    $book->setTitle($data[0]);
    $book->setAuthor($data[1]);
    $book->setYear($data[2]);
    $book->setPrice($data[3]);

    $em->persist($book);
}

$em->flush();

echo "Demo books added successfully!\n";
