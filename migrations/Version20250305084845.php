<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250305084845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE clothing_item (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, categorie_id INT NOT NULL, prix NUMERIC(10, 2) NOT NULL, image_url VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE history (id SERIAL NOT NULL, utilisateur_id INT NOT NULL, tenue_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE notification (id SERIAL NOT NULL, contenu TEXT NOT NULL, utilisateur_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE partner (id SERIAL NOT NULL, nom VARCHAR(100) NOT NULL, lien VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE role (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE statistics (id SERIAL NOT NULL, metrique VARCHAR(255) NOT NULL, valeur INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE garment ADD season VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE garment ADD material VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE garment ADD occasion VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE clothing_item');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE statistics');
        $this->addSql('ALTER TABLE garment DROP season');
        $this->addSql('ALTER TABLE garment DROP material');
        $this->addSql('ALTER TABLE garment DROP occasion');
    }
}
