<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307101016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garment (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(50) NOT NULL, color VARCHAR(50) NOT NULL, style VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, season VARCHAR(50) DEFAULT NULL, material VARCHAR(50) DEFAULT NULL, occasion VARCHAR(50) DEFAULT NULL, is_shared TINYINT(1) NOT NULL, INDEX IDX_B881175C67B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE outfit (id INT AUTO_INCREMENT NOT NULL, date_creation DATETIME NOT NULL, public TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE garment ADD CONSTRAINT FK_B881175C67B3B43D FOREIGN KEY (users_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garment DROP FOREIGN KEY FK_B881175C67B3B43D');
        $this->addSql('DROP TABLE garment');
        $this->addSql('DROP TABLE outfit');
        $this->addSql('ALTER TABLE `user` CHANGE email email VARCHAR(180) NOT NULL');
    }
}
