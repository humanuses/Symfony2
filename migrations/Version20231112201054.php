<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231112201054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE zasoby (id INT AUTO_INCREMENT NOT NULL, nazwa_artykulu_id INT NOT NULL, jednostka_miary_id INT NOT NULL, magazyn_id INT NOT NULL, ilosc DOUBLE PRECISION NOT NULL, vat DOUBLE PRECISION NOT NULL, cena_jednostkowa DOUBLE PRECISION NOT NULL, wartosc_podatku DOUBLE PRECISION NOT NULL, wartosc_brutto DOUBLE PRECISION NOT NULL, INDEX IDX_FB3A922B29B76C38 (nazwa_artykulu_id), INDEX IDX_FB3A922BD76EA435 (jednostka_miary_id), INDEX IDX_FB3A922B67E6ACA9 (magazyn_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE zasoby ADD CONSTRAINT FK_FB3A922B29B76C38 FOREIGN KEY (nazwa_artykulu_id) REFERENCES artykul (id)');
        $this->addSql('ALTER TABLE zasoby ADD CONSTRAINT FK_FB3A922BD76EA435 FOREIGN KEY (jednostka_miary_id) REFERENCES jednostka (id)');
        $this->addSql('ALTER TABLE zasoby ADD CONSTRAINT FK_FB3A922B67E6ACA9 FOREIGN KEY (magazyn_id) REFERENCES magazyn (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE zasoby DROP FOREIGN KEY FK_FB3A922B29B76C38');
        $this->addSql('ALTER TABLE zasoby DROP FOREIGN KEY FK_FB3A922BD76EA435');
        $this->addSql('ALTER TABLE zasoby DROP FOREIGN KEY FK_FB3A922B67E6ACA9');
        $this->addSql('DROP TABLE zasoby');
    }
}
