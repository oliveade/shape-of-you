<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250306153239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id UUID NOT NULL, parent_category_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, deleted BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');
        $this->addSql('CREATE INDEX IDX_64C19C1796A8F92 ON category (parent_category_id)');
        $this->addSql('COMMENT ON COLUMN category.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN category.parent_category_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN category.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN category.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE history (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN history.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN history.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN history.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE outfit (id UUID NOT NULL, owner_id UUID NOT NULL, history_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, published BOOLEAN NOT NULL, deleted BOOLEAN NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_320296017E3C61F9 ON outfit (owner_id)');
        $this->addSql('CREATE INDEX IDX_320296011E058452 ON outfit (history_id)');
        $this->addSql('COMMENT ON COLUMN outfit.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN outfit.owner_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN outfit.history_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN outfit.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN outfit.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN outfit.published_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN outfit.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE outfit_piece (outfit_id UUID NOT NULL, piece_id UUID NOT NULL, PRIMARY KEY(outfit_id, piece_id))');
        $this->addSql('CREATE INDEX IDX_D60E1FDFAE96E385 ON outfit_piece (outfit_id)');
        $this->addSql('CREATE INDEX IDX_D60E1FDFC40FCFA8 ON outfit_piece (piece_id)');
        $this->addSql('COMMENT ON COLUMN outfit_piece.outfit_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN outfit_piece.piece_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE partner_link (id UUID NOT NULL, piece_id UUID DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, link TEXT NOT NULL, active BOOLEAN NOT NULL, deleted BOOLEAN NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6698AAE9989D9B62 ON partner_link (slug)');
        $this->addSql('CREATE INDEX IDX_6698AAE9C40FCFA8 ON partner_link (piece_id)');
        $this->addSql('COMMENT ON COLUMN partner_link.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN partner_link.piece_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN partner_link.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN partner_link.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN partner_link.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE piece (id UUID NOT NULL, category_id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, body_type VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) NOT NULL, deleted BOOLEAN NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44CA0B23989D9B62 ON piece (slug)');
        $this->addSql('CREATE INDEX IDX_44CA0B2312469DE2 ON piece (category_id)');
        $this->addSql('COMMENT ON COLUMN piece.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN piece.category_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN piece.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN piece.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN piece.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE piece_user (piece_id UUID NOT NULL, user_id UUID NOT NULL, PRIMARY KEY(piece_id, user_id))');
        $this->addSql('CREATE INDEX IDX_89FBED10C40FCFA8 ON piece_user (piece_id)');
        $this->addSql('CREATE INDEX IDX_89FBED10A76ED395 ON piece_user (user_id)');
        $this->addSql('COMMENT ON COLUMN piece_user.piece_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN piece_user.user_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE season (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, deleted BOOLEAN NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F0E45BA9989D9B62 ON season (slug)');
        $this->addSql('COMMENT ON COLUMN season.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN season.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN season.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN season.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE season_piece (season_id UUID NOT NULL, piece_id UUID NOT NULL, PRIMARY KEY(season_id, piece_id))');
        $this->addSql('CREATE INDEX IDX_53FBFCFC4EC001D1 ON season_piece (season_id)');
        $this->addSql('CREATE INDEX IDX_53FBFCFCC40FCFA8 ON season_piece (piece_id)');
        $this->addSql('COMMENT ON COLUMN season_piece.season_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN season_piece.piece_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE season_outfit (season_id UUID NOT NULL, outfit_id UUID NOT NULL, PRIMARY KEY(season_id, outfit_id))');
        $this->addSql('CREATE INDEX IDX_247968B34EC001D1 ON season_outfit (season_id)');
        $this->addSql('CREATE INDEX IDX_247968B3AE96E385 ON season_outfit (outfit_id)');
        $this->addSql('COMMENT ON COLUMN season_outfit.season_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN season_outfit.outfit_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE tag (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, deleted BOOLEAN NOT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN tag.id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN tag.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tag.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tag.deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE tag_piece (tag_id UUID NOT NULL, piece_id UUID NOT NULL, PRIMARY KEY(tag_id, piece_id))');
        $this->addSql('CREATE INDEX IDX_66261225BAD26311 ON tag_piece (tag_id)');
        $this->addSql('CREATE INDEX IDX_66261225C40FCFA8 ON tag_piece (piece_id)');
        $this->addSql('COMMENT ON COLUMN tag_piece.tag_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN tag_piece.piece_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE tag_outfit (tag_id UUID NOT NULL, outfit_id UUID NOT NULL, PRIMARY KEY(tag_id, outfit_id))');
        $this->addSql('CREATE INDEX IDX_DB43DF2DBAD26311 ON tag_outfit (tag_id)');
        $this->addSql('CREATE INDEX IDX_DB43DF2DAE96E385 ON tag_outfit (outfit_id)');
        $this->addSql('COMMENT ON COLUMN tag_outfit.tag_id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN tag_outfit.outfit_id IS \'(DC2Type:ulid)\'');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, avatar_url VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, status VARCHAR(255) NOT NULL, banned_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:ulid)\'');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".banned_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "user".deleted_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1796A8F92 FOREIGN KEY (parent_category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_320296017E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE outfit ADD CONSTRAINT FK_320296011E058452 FOREIGN KEY (history_id) REFERENCES history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE outfit_piece ADD CONSTRAINT FK_D60E1FDFAE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE outfit_piece ADD CONSTRAINT FK_D60E1FDFC40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner_link ADD CONSTRAINT FK_6698AAE9C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B2312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece_user ADD CONSTRAINT FK_89FBED10C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece_user ADD CONSTRAINT FK_89FBED10A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE season_piece ADD CONSTRAINT FK_53FBFCFC4EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE season_piece ADD CONSTRAINT FK_53FBFCFCC40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE season_outfit ADD CONSTRAINT FK_247968B34EC001D1 FOREIGN KEY (season_id) REFERENCES season (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE season_outfit ADD CONSTRAINT FK_247968B3AE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_piece ADD CONSTRAINT FK_66261225BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_piece ADD CONSTRAINT FK_66261225C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_outfit ADD CONSTRAINT FK_DB43DF2DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tag_outfit ADD CONSTRAINT FK_DB43DF2DAE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT FK_64C19C1796A8F92');
        $this->addSql('ALTER TABLE outfit DROP CONSTRAINT FK_320296017E3C61F9');
        $this->addSql('ALTER TABLE outfit DROP CONSTRAINT FK_320296011E058452');
        $this->addSql('ALTER TABLE outfit_piece DROP CONSTRAINT FK_D60E1FDFAE96E385');
        $this->addSql('ALTER TABLE outfit_piece DROP CONSTRAINT FK_D60E1FDFC40FCFA8');
        $this->addSql('ALTER TABLE partner_link DROP CONSTRAINT FK_6698AAE9C40FCFA8');
        $this->addSql('ALTER TABLE piece DROP CONSTRAINT FK_44CA0B2312469DE2');
        $this->addSql('ALTER TABLE piece_user DROP CONSTRAINT FK_89FBED10C40FCFA8');
        $this->addSql('ALTER TABLE piece_user DROP CONSTRAINT FK_89FBED10A76ED395');
        $this->addSql('ALTER TABLE season_piece DROP CONSTRAINT FK_53FBFCFC4EC001D1');
        $this->addSql('ALTER TABLE season_piece DROP CONSTRAINT FK_53FBFCFCC40FCFA8');
        $this->addSql('ALTER TABLE season_outfit DROP CONSTRAINT FK_247968B34EC001D1');
        $this->addSql('ALTER TABLE season_outfit DROP CONSTRAINT FK_247968B3AE96E385');
        $this->addSql('ALTER TABLE tag_piece DROP CONSTRAINT FK_66261225BAD26311');
        $this->addSql('ALTER TABLE tag_piece DROP CONSTRAINT FK_66261225C40FCFA8');
        $this->addSql('ALTER TABLE tag_outfit DROP CONSTRAINT FK_DB43DF2DBAD26311');
        $this->addSql('ALTER TABLE tag_outfit DROP CONSTRAINT FK_DB43DF2DAE96E385');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE outfit');
        $this->addSql('DROP TABLE outfit_piece');
        $this->addSql('DROP TABLE partner_link');
        $this->addSql('DROP TABLE piece');
        $this->addSql('DROP TABLE piece_user');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE season_piece');
        $this->addSql('DROP TABLE season_outfit');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_piece');
        $this->addSql('DROP TABLE tag_outfit');
        $this->addSql('DROP TABLE "user"');
    }
}
