<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251123104211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "Group" ADD COLUMN is_explicit BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE "Group" ADD COLUMN is_moderated BOOLEAN DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__Group AS SELECT id, token, name, created_at, image1_name, image2_name, description FROM "Group"');
        $this->addSql('DROP TABLE "Group"');
        $this->addSql('CREATE TABLE "Group" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, token CHAR(36) NOT NULL --(DC2Type:guid)
        , name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , image1_name VARCHAR(255) DEFAULT NULL, image2_name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO "Group" (id, token, name, created_at, image1_name, image2_name, description) SELECT id, token, name, created_at, image1_name, image2_name, description FROM __temp__Group');
        $this->addSql('DROP TABLE __temp__Group');
    }
}
