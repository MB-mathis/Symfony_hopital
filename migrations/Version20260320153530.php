<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260320153530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD dossier_medical_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A767750B79F FOREIGN KEY (dossier_medical_id) REFERENCES dossier_medical (id)');
        $this->addSql('CREATE INDEX IDX_D8698A767750B79F ON document (dossier_medical_id)');
        $this->addSql('ALTER TABLE greffe CHANGE donneur_id donneur_id INT NOT NULL, CHANGE chirurgien_id chirurgien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient CHANGE updated_by_id updated_by_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A767750B79F');
        $this->addSql('DROP INDEX IDX_D8698A767750B79F ON document');
        $this->addSql('ALTER TABLE document DROP dossier_medical_id');
        $this->addSql('ALTER TABLE greffe CHANGE donneur_id donneur_id INT DEFAULT NULL, CHANGE chirurgien_id chirurgien_id INT NOT NULL');
        $this->addSql('ALTER TABLE patient CHANGE updated_by_id updated_by_id INT NOT NULL');
    }
}
