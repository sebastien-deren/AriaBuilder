<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926094746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnage_background DROP CONSTRAINT fk_273d6f455e315342');
        $this->addSql('ALTER TABLE personnage_background DROP CONSTRAINT fk_273d6f45c93d69ea');
        $this->addSql('DROP TABLE personnage_background');
        $this->addSql('ALTER TABLE background ADD personnage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE background ADD CONSTRAINT FK_BC68B4505E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BC68B4505E315342 ON background (personnage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE personnage_background (personnage_id INT NOT NULL, background_id INT NOT NULL, PRIMARY KEY(personnage_id, background_id))');
        $this->addSql('CREATE INDEX idx_273d6f45c93d69ea ON personnage_background (background_id)');
        $this->addSql('CREATE INDEX idx_273d6f455e315342 ON personnage_background (personnage_id)');
        $this->addSql('ALTER TABLE personnage_background ADD CONSTRAINT fk_273d6f455e315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE personnage_background ADD CONSTRAINT fk_273d6f45c93d69ea FOREIGN KEY (background_id) REFERENCES background (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE background DROP CONSTRAINT FK_BC68B4505E315342');
        $this->addSql('DROP INDEX IDX_BC68B4505E315342');
        $this->addSql('ALTER TABLE background DROP personnage_id');
    }
}
