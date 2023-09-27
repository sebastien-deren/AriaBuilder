<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230927084945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE talent_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE talent (id INT NOT NULL, personnage_id INT DEFAULT NULL, bonus INT NOT NULL, number_of_talent INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16D902F55E315342 ON talent (personnage_id)');
        $this->addSql('CREATE TABLE talent_competence_personnage (talent_id INT NOT NULL, competence_personnage_id INT NOT NULL, PRIMARY KEY(talent_id, competence_personnage_id))');
        $this->addSql('CREATE INDEX IDX_D10F2FF218777CEF ON talent_competence_personnage (talent_id)');
        $this->addSql('CREATE INDEX IDX_D10F2FF22F1E91A9 ON talent_competence_personnage (competence_personnage_id)');
        $this->addSql('ALTER TABLE talent ADD CONSTRAINT FK_16D902F55E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE talent_competence_personnage ADD CONSTRAINT FK_D10F2FF218777CEF FOREIGN KEY (talent_id) REFERENCES talent (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE talent_competence_personnage ADD CONSTRAINT FK_D10F2FF22F1E91A9 FOREIGN KEY (competence_personnage_id) REFERENCES competence_personnage (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE talent_id_seq CASCADE');
        $this->addSql('ALTER TABLE talent DROP CONSTRAINT FK_16D902F55E315342');
        $this->addSql('ALTER TABLE talent_competence_personnage DROP CONSTRAINT FK_D10F2FF218777CEF');
        $this->addSql('ALTER TABLE talent_competence_personnage DROP CONSTRAINT FK_D10F2FF22F1E91A9');
        $this->addSql('DROP TABLE talent');
        $this->addSql('DROP TABLE talent_competence_personnage');
    }
}
