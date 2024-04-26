<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425124231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile ADD magical_level_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FD536E648 FOREIGN KEY (magical_level_id) REFERENCES magical_level (id)');
        $this->addSql('CREATE INDEX IDX_8157AA0FD536E648 ON profile (magical_level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FD536E648');
        $this->addSql('DROP INDEX IDX_8157AA0FD536E648 ON profile');
        $this->addSql('ALTER TABLE profile DROP magical_level_id');
    }
}
