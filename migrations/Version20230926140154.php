<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926140154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE background_id_seq CASCADE');
        $this->addSql('ALTER TABLE background DROP CONSTRAINT fk_bc68b450b2fbd70f');
        $this->addSql('ALTER TABLE background DROP CONSTRAINT fk_bc68b450762c1ff5');
        $this->addSql('ALTER TABLE background DROP CONSTRAINT fk_bc68b4505e315342');
        $this->addSql('DROP TABLE background');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE background_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE background (id INT NOT NULL, competence_bonus_id INT NOT NULL, competence_malus_id INT NOT NULL, personnage_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_bc68b4505e315342 ON background (personnage_id)');
        $this->addSql('CREATE INDEX idx_bc68b450762c1ff5 ON background (competence_malus_id)');
        $this->addSql('CREATE INDEX idx_bc68b450b2fbd70f ON background (competence_bonus_id)');
        $this->addSql('ALTER TABLE background ADD CONSTRAINT fk_bc68b450b2fbd70f FOREIGN KEY (competence_bonus_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE background ADD CONSTRAINT fk_bc68b450762c1ff5 FOREIGN KEY (competence_malus_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE background ADD CONSTRAINT fk_bc68b4505e315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
