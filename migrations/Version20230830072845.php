<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230830072845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE caracteristique_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE competence_personnage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE personnage_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE profession_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE caracteristique (id INT NOT NULL, personnage_id INT NOT NULL, force INT DEFAULT NULL, endurance INT DEFAULT NULL, dexterite INT DEFAULT NULL, intelligence INT NOT NULL, charisme INT DEFAULT NULL, carac_point INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D14FBE8B5E315342 ON caracteristique (personnage_id)');
        $this->addSql('CREATE TABLE competence (id INT NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, first_charac VARCHAR(255) DEFAULT NULL, second_charac VARCHAR(255) DEFAULT NULL, is_base_competence BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE competence_personnage (id INT NOT NULL, personage_id INT DEFAULT NULL, competence_id INT DEFAULT NULL, pourcentage INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_446AF09AEA8E3E4A ON competence_personnage (personage_id)');
        $this->addSql('CREATE INDEX IDX_446AF09A15761DAB ON competence_personnage (competence_id)');
        $this->addSql('CREATE TABLE personnage (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, age VARCHAR(255) NOT NULL, genie VARCHAR(255) NOT NULL, societe VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE profession (id INT NOT NULL, competence_premiere_id INT NOT NULL, competence_seconde_id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BA930D6949091F5F ON profession (competence_premiere_id)');
        $this->addSql('CREATE INDEX IDX_BA930D692EAE1511 ON profession (competence_seconde_id)');
        $this->addSql('ALTER TABLE caracteristique ADD CONSTRAINT FK_D14FBE8B5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence_personnage ADD CONSTRAINT FK_446AF09AEA8E3E4A FOREIGN KEY (personage_id) REFERENCES personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE competence_personnage ADD CONSTRAINT FK_446AF09A15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profession ADD CONSTRAINT FK_BA930D6949091F5F FOREIGN KEY (competence_premiere_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profession ADD CONSTRAINT FK_BA930D692EAE1511 FOREIGN KEY (competence_seconde_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE caracteristique_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competence_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE competence_personnage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE personnage_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE profession_id_seq CASCADE');
        $this->addSql('ALTER TABLE caracteristique DROP CONSTRAINT FK_D14FBE8B5E315342');
        $this->addSql('ALTER TABLE competence_personnage DROP CONSTRAINT FK_446AF09AEA8E3E4A');
        $this->addSql('ALTER TABLE competence_personnage DROP CONSTRAINT FK_446AF09A15761DAB');
        $this->addSql('ALTER TABLE profession DROP CONSTRAINT FK_BA930D6949091F5F');
        $this->addSql('ALTER TABLE profession DROP CONSTRAINT FK_BA930D692EAE1511');
        $this->addSql('DROP TABLE caracteristique');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE competence_personnage');
        $this->addSql('DROP TABLE personnage');
        $this->addSql('DROP TABLE profession');
    }
}
