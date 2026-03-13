<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260313134247 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chirurgien (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE donneur (id INT AUTO_INCREMENT NOT NULL, groupe_sanguin VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, taille DOUBLE PRECISION DEFAULT NULL, data JSON NOT NULL, type_donneur VARCHAR(255) NOT NULL, date_naissance DATETIME NOT NULL, poids DOUBLE PRECISION DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, numero_crista VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE dossier_medical (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, patient_id INT NOT NULL, created_by_id INT NOT NULL, UNIQUE INDEX UNIQ_3581EE626B899279 (patient_id), INDEX IDX_3581EE62B03A8386 (created_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE greffe (id INT AUTO_INCREMENT NOT NULL, date_greffe DATETIME NOT NULL, rang_greffe INT NOT NULL, type_greffe VARCHAR(255) NOT NULL, greffon_fonctionnel TINYINT NOT NULL, date_fin_fonction_greffon DATETIME DEFAULT NULL, cause_fin_fonction_greffon VARCHAR(255) DEFAULT NULL, dialyse TINYINT NOT NULL, date_derniere_dialyse DATETIME DEFAULT NULL, protocole TINYINT DEFAULT NULL, protocole_fichier VARCHAR(255) DEFAULT NULL, data JSON DEFAULT NULL, donneur_id INT DEFAULT NULL, dossier_medical_id INT NOT NULL, chirurgien_id INT NOT NULL, INDEX IDX_69FCC4BB9789825B (donneur_id), INDEX IDX_69FCC4BB7750B79F (dossier_medical_id), INDEX IDX_69FCC4BB6DB64F5D (chirurgien_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, sexe VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dossier_medical ADD CONSTRAINT FK_3581EE626B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE dossier_medical ADD CONSTRAINT FK_3581EE62B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE greffe ADD CONSTRAINT FK_69FCC4BB9789825B FOREIGN KEY (donneur_id) REFERENCES donneur (id)');
        $this->addSql('ALTER TABLE greffe ADD CONSTRAINT FK_69FCC4BB7750B79F FOREIGN KEY (dossier_medical_id) REFERENCES dossier_medical (id)');
        $this->addSql('ALTER TABLE greffe ADD CONSTRAINT FK_69FCC4BB6DB64F5D FOREIGN KEY (chirurgien_id) REFERENCES chirurgien (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_medical DROP FOREIGN KEY FK_3581EE626B899279');
        $this->addSql('ALTER TABLE dossier_medical DROP FOREIGN KEY FK_3581EE62B03A8386');
        $this->addSql('ALTER TABLE greffe DROP FOREIGN KEY FK_69FCC4BB9789825B');
        $this->addSql('ALTER TABLE greffe DROP FOREIGN KEY FK_69FCC4BB7750B79F');
        $this->addSql('ALTER TABLE greffe DROP FOREIGN KEY FK_69FCC4BB6DB64F5D');
        $this->addSql('DROP TABLE chirurgien');
        $this->addSql('DROP TABLE donneur');
        $this->addSql('DROP TABLE dossier_medical');
        $this->addSql('DROP TABLE greffe');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
