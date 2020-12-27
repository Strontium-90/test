<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\Author;
use App\Entity\Book;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201227100032 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE authors_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE books_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE authors (id INT NOT NULL, name VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE author_book (author_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(author_id, book_id))');
        $this->addSql('CREATE INDEX IDX_2F0A2BEEF675F31B ON author_book (author_id)');
        $this->addSql('CREATE INDEX IDX_2F0A2BEE16A2B381 ON author_book (book_id)');
        $this->addSql('CREATE TABLE books (id INT NOT NULL, name VARCHAR(1000) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE book_authors (book_id INT NOT NULL, author_id INT NOT NULL, PRIMARY KEY(book_id, author_id))');
        $this->addSql('CREATE INDEX IDX_1D2C02C716A2B381 ON book_authors (book_id)');
        $this->addSql('CREATE INDEX IDX_1D2C02C7F675F31B ON book_authors (author_id)');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEEF675F31B FOREIGN KEY (author_id) REFERENCES authors (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEE16A2B381 FOREIGN KEY (book_id) REFERENCES books (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_authors ADD CONSTRAINT FK_1D2C02C716A2B381 FOREIGN KEY (book_id) REFERENCES books (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book_authors ADD CONSTRAINT FK_1D2C02C7F675F31B FOREIGN KEY (author_id) REFERENCES authors (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

    }

    public function postUp(Schema $schema): void
    {
        $faker = Factory::create();
        /** @var EntityManagerInterface $manager */
        $manager = $this->container->get('doctrine.orm.entity_manager');

        $books = [];
        $authors = [];

        for ($i = 0; $i < $faker->numberBetween(9000, 11000); $i++) {
            $book = (new Book())
                ->setName($faker->sentence(4, true));
            $manager->persist($book);
            $manager->flush($book);

            $books[] = $book->getId();
            $manager->clear();
        }

        for ($i = 0; $i < $faker->numberBetween(9000, 11000); $i++) {
            $author = (new Author())
                ->setName($faker->name);
            $manager->persist($author);
            $manager->flush($author);

            $authors[] = $author->getId();
            $manager->clear();
        }

        foreach ($books as $bookId) {
            /** @var Book $book */
            $book = $manager->getReference(Book::class, $bookId);
            $authorIds = $faker->randomElements($authors, $faker->numberBetween(1, 2));
            foreach ($authorIds as $authorId) {
                /** @var Author $author */
                $author = $manager->getReference(Author::class, $authorId);
                $book->addAuthor($author);
            }
            $manager->flush();
            $manager->clear();
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE author_book DROP CONSTRAINT FK_2F0A2BEEF675F31B');
        $this->addSql('ALTER TABLE book_authors DROP CONSTRAINT FK_1D2C02C7F675F31B');
        $this->addSql('ALTER TABLE author_book DROP CONSTRAINT FK_2F0A2BEE16A2B381');
        $this->addSql('ALTER TABLE book_authors DROP CONSTRAINT FK_1D2C02C716A2B381');
        $this->addSql('DROP SEQUENCE authors_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE books_id_seq CASCADE');
        $this->addSql('DROP TABLE authors');
        $this->addSql('DROP TABLE author_book');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE book_authors');
    }
}
