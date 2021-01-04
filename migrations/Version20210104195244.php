<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210104195244 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user ADD changer_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E53CD0CE FOREIGN KEY (changer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649E53CD0CE ON user (changer_id)');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E53CD0CE');
        $this->addSql('DROP INDEX IDX_8D93D649E53CD0CE ON user');
        $this->addSql('ALTER TABLE user DROP changer_id, DROP created_at, DROP updated_at, DROP deleted_at');
    }
}
