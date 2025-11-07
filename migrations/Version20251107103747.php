<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251107103747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__photo AS SELECT id, group_id, commentary, is_allowed, created_at FROM photo');
        $this->addSql('DROP TABLE photo');
        $this->addSql('CREATE TABLE photo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, group_id INTEGER NOT NULL, commentary VARCHAR(255) DEFAULT NULL, is_allowed BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , image_name VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_14B78418FE54D947 FOREIGN KEY (group_id) REFERENCES "Group" (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO photo (id, group_id, commentary, is_allowed, created_at) SELECT id, group_id, commentary, is_allowed, created_at FROM __temp__photo');
        $this->addSql('DROP TABLE __temp__photo');
        $this->addSql('CREATE INDEX IDX_14B78418FE54D947 ON photo (group_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__photo AS SELECT id, group_id, commentary, is_allowed, created_at FROM photo');
        $this->addSql('DROP TABLE photo');
        $this->addSql('CREATE TABLE photo (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, group_id INTEGER NOT NULL, commentary VARCHAR(255) DEFAULT NULL, is_allowed BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , media VARCHAR(255) NOT NULL, CONSTRAINT FK_14B78418FE54D947 FOREIGN KEY (group_id) REFERENCES "Group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO photo (id, group_id, commentary, is_allowed, created_at) SELECT id, group_id, commentary, is_allowed, created_at FROM __temp__photo');
        $this->addSql('DROP TABLE __temp__photo');
        $this->addSql('CREATE INDEX IDX_14B78418FE54D947 ON photo (group_id)');
    }
}
