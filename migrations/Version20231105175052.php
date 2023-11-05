<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105175052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artykul (id INT AUTO_INCREMENT NOT NULL, jednostka_rozliczenia_id INT NOT NULL, nazwa_artykulu VARCHAR(255) NOT NULL, INDEX IDX_BEEC19FD258A2416 (jednostka_rozliczenia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jednostka (id INT AUTO_INCREMENT NOT NULL, nazwa_jednostki VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE artykul ADD CONSTRAINT FK_BEEC19FD258A2416 FOREIGN KEY (jednostka_rozliczenia_id) REFERENCES jednostka (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artykul DROP FOREIGN KEY FK_BEEC19FD258A2416');
        $this->addSql('DROP TABLE artykul');
        $this->addSql('DROP TABLE jednostka');
    }
}
