<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230927140039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE background DROP CONSTRAINT FK_BC68B450B2FBD70F');
        $this->addSql('ALTER TABLE background DROP CONSTRAINT FK_BC68B450762C1FF5');
        $this->addSql('ALTER TABLE background ADD CONSTRAINT FK_BC68B450B2FBD70F FOREIGN KEY (competence_bonus_id) REFERENCES competence_personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE background ADD CONSTRAINT FK_BC68B450762C1FF5 FOREIGN KEY (competence_malus_id) REFERENCES competence_personnage (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE background DROP CONSTRAINT fk_bc68b450b2fbd70f');
        $this->addSql('ALTER TABLE background DROP CONSTRAINT fk_bc68b450762c1ff5');
        $this->addSql('ALTER TABLE background ADD CONSTRAINT fk_bc68b450b2fbd70f FOREIGN KEY (competence_bonus_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE background ADD CONSTRAINT fk_bc68b450762c1ff5 FOREIGN KEY (competence_malus_id) REFERENCES competence (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
