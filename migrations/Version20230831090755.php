<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230831090755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caracteristique DROP CONSTRAINT fk_d14fbe8b5e315342');
        $this->addSql('DROP INDEX uniq_d14fbe8b5e315342');
        $this->addSql('ALTER TABLE caracteristique DROP personnage_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE caracteristique ADD personnage_id INT NOT NULL');
        $this->addSql('ALTER TABLE caracteristique ADD CONSTRAINT fk_d14fbe8b5e315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_d14fbe8b5e315342 ON caracteristique (personnage_id)');
    }
}
