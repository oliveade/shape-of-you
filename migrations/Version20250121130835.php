<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121130835 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garment (id SERIAL NOT NULL, users_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(50) NOT NULL, color VARCHAR(50) NOT NULL, style VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B881175C67B3B43D ON garment (users_id)');
        $this->addSql('ALTER TABLE garment ADD CONSTRAINT FK_B881175C67B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE garment DROP CONSTRAINT FK_B881175C67B3B43D');
        $this->addSql('DROP TABLE garment');
    }
}
