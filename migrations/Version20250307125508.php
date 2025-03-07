<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250307125508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garment (id SERIAL NOT NULL, users_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, type VARCHAR(50) NOT NULL, color VARCHAR(50) NOT NULL, style VARCHAR(255) DEFAULT NULL, image_url VARCHAR(255) NOT NULL, season VARCHAR(50) DEFAULT NULL, material VARCHAR(50) DEFAULT NULL, occasion VARCHAR(50) DEFAULT NULL, is_shared BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B881175C67B3B43D ON garment (users_id)');
        $this->addSql('CREATE TABLE outfit (id SERIAL NOT NULL, date_creation TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, public BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, birthdate DATE NOT NULL, roles JSON NOT NULL, deleted BOOLEAN NOT NULL, created_by VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE garment ADD CONSTRAINT FK_B881175C67B3B43D FOREIGN KEY (users_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE garment DROP CONSTRAINT FK_B881175C67B3B43D');
        $this->addSql('DROP TABLE garment');
        $this->addSql('DROP TABLE outfit');
        $this->addSql('DROP TABLE "user"');
    }
}
