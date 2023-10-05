<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230927144335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence_personnage DROP CONSTRAINT fk_446af09aea8e3e4a');
        $this->addSql('DROP INDEX idx_446af09aea8e3e4a');
        $this->addSql('ALTER TABLE competence_personnage RENAME COLUMN personage_id TO personnage_id');
        $this->addSql('ALTER TABLE competence_personnage ADD CONSTRAINT FK_446AF09A5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_446AF09A5E315342 ON competence_personnage (personnage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE competence_personnage DROP CONSTRAINT FK_446AF09A5E315342');
        $this->addSql('DROP INDEX IDX_446AF09A5E315342');
        $this->addSql('ALTER TABLE competence_personnage RENAME COLUMN personnage_id TO personage_id');
        $this->addSql('ALTER TABLE competence_personnage ADD CONSTRAINT fk_446af09aea8e3e4a FOREIGN KEY (personage_id) REFERENCES personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_446af09aea8e3e4a ON competence_personnage (personage_id)');
    }
}
