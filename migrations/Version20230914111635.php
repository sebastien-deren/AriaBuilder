<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914111635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caracteristique ALTER force SET NOT NULL');
        $this->addSql('ALTER TABLE caracteristique ALTER endurance SET NOT NULL');
        $this->addSql('ALTER TABLE caracteristique ALTER dexterite SET NOT NULL');
        $this->addSql('ALTER TABLE caracteristique ALTER charisme SET NOT NULL');
        $this->addSql('ALTER TABLE personnage ALTER genie DROP NOT NULL');
        $this->addSql('ALTER TABLE personnage ALTER societe DROP NOT NULL');
        $this->addSql('ALTER TABLE profession DROP CONSTRAINT fk_ba930d6949091f5f');
        $this->addSql('ALTER TABLE profession DROP CONSTRAINT fk_ba930d692eae1511');
        $this->addSql('DROP INDEX idx_ba930d692eae1511');
        $this->addSql('DROP INDEX idx_ba930d6949091f5f');
        $this->addSql('ALTER TABLE profession DROP competence_premiere_id');
        $this->addSql('ALTER TABLE profession DROP competence_seconde_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE personnage ALTER genie SET NOT NULL');
        $this->addSql('ALTER TABLE personnage ALTER societe SET NOT NULL');
        $this->addSql('ALTER TABLE caracteristique ALTER force DROP NOT NULL');
        $this->addSql('ALTER TABLE caracteristique ALTER endurance DROP NOT NULL');
        $this->addSql('ALTER TABLE caracteristique ALTER dexterite DROP NOT NULL');
        $this->addSql('ALTER TABLE caracteristique ALTER charisme DROP NOT NULL');
        $this->addSql('ALTER TABLE profession ADD competence_premiere_id INT NOT NULL');
        $this->addSql('ALTER TABLE profession ADD competence_seconde_id INT NOT NULL');
        $this->addSql('ALTER TABLE profession ADD CONSTRAINT fk_ba930d6949091f5f FOREIGN KEY (competence_premiere_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profession ADD CONSTRAINT fk_ba930d692eae1511 FOREIGN KEY (competence_seconde_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ba930d692eae1511 ON profession (competence_seconde_id)');
        $this->addSql('CREATE INDEX idx_ba930d6949091f5f ON profession (competence_premiere_id)');
    }
}
