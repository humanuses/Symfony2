<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231105120301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE magazyn (id INT AUTO_INCREMENT NOT NULL, nazwa_magazynu VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_magazyn (user_id INT NOT NULL, magazyn_id INT NOT NULL, INDEX IDX_49B168F3A76ED395 (user_id), INDEX IDX_49B168F367E6ACA9 (magazyn_id), PRIMARY KEY(user_id, magazyn_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_magazyn ADD CONSTRAINT FK_49B168F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_magazyn ADD CONSTRAINT FK_49B168F367E6ACA9 FOREIGN KEY (magazyn_id) REFERENCES magazyn (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_8D93D649F85E0677 ON user');
        $this->addSql('ALTER TABLE user CHANGE crkp crkp BIGINT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64989AEF89F ON user (crkp)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_magazyn DROP FOREIGN KEY FK_49B168F3A76ED395');
        $this->addSql('ALTER TABLE user_magazyn DROP FOREIGN KEY FK_49B168F367E6ACA9');
        $this->addSql('DROP TABLE magazyn');
        $this->addSql('DROP TABLE user_magazyn');
        $this->addSql('DROP INDEX UNIQ_8D93D64989AEF89F ON user');
        $this->addSql('ALTER TABLE user CHANGE crkp crkp INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
    }
}
