<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230914114100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profession_competence (profession_id INT NOT NULL, competence_id INT NOT NULL, PRIMARY KEY(profession_id, competence_id))');
        $this->addSql('CREATE INDEX IDX_9DD60F9EFDEF8996 ON profession_competence (profession_id)');
        $this->addSql('CREATE INDEX IDX_9DD60F9E15761DAB ON profession_competence (competence_id)');
        $this->addSql('ALTER TABLE profession_competence ADD CONSTRAINT FK_9DD60F9EFDEF8996 FOREIGN KEY (profession_id) REFERENCES profession (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profession_competence ADD CONSTRAINT FK_9DD60F9E15761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE profession_competence DROP CONSTRAINT FK_9DD60F9EFDEF8996');
        $this->addSql('ALTER TABLE profession_competence DROP CONSTRAINT FK_9DD60F9E15761DAB');
        $this->addSql('DROP TABLE profession_competence');
    }
}
