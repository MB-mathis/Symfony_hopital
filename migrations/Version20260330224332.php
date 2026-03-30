<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260330224332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conditionnement_immunologique (id INT AUTO_INCREMENT NOT NULL, risque_immunologique VARCHAR(255) DEFAULT NULL, commentaire_risque_immunologique LONGTEXT DEFAULT NULL, commentaire_conditionnement LONGTEXT DEFAULT NULL, conditionnement_immunosuppresseur VARCHAR(255) DEFAULT NULL, greffe_id INT NOT NULL, UNIQUE INDEX UNIQ_7C9AFF93B4D778D5 (greffe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE groupe_hla (id INT AUTO_INCREMENT NOT NULL, hla_amismatch INT NOT NULL, hla_bmismatch INT NOT NULL, hla_cw_mismatch INT DEFAULT NULL, hla_dqmismatch INT NOT NULL, hla_dpmismatch INT DEFAULT NULL, greffe_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_C5D8D442B4D778D5 (greffe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE prelevement (id INT AUTO_INCREMENT NOT NULL, date_declampage DATETIME DEFAULT NULL, heure_declampage TIME DEFAULT NULL, cote_prelevement VARCHAR(255) DEFAULT NULL, cote_transplantation VARCHAR(255) DEFAULT NULL, en VARCHAR(255) DEFAULT NULL, ischemie_totale TIME DEFAULT NULL, duree_anastomoses INT DEFAULT NULL, sonde_jj TINYINT DEFAULT NULL, commentaire_prelevement LONGTEXT DEFAULT NULL, greffe_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_88C8671FB4D778D5 (greffe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE serologie (id INT AUTO_INCREMENT NOT NULL, cmv_status VARCHAR(255) DEFAULT NULL, ebv_status VARCHAR(255) DEFAULT NULL, toxo_status VARCHAR(255) DEFAULT NULL, greffe_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_CE81DC69B4D778D5 (greffe_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE conditionnement_immunologique ADD CONSTRAINT FK_7C9AFF93B4D778D5 FOREIGN KEY (greffe_id) REFERENCES greffe (id)');
        $this->addSql('ALTER TABLE groupe_hla ADD CONSTRAINT FK_C5D8D442B4D778D5 FOREIGN KEY (greffe_id) REFERENCES greffe (id)');
        $this->addSql('ALTER TABLE prelevement ADD CONSTRAINT FK_88C8671FB4D778D5 FOREIGN KEY (greffe_id) REFERENCES greffe (id)');
        $this->addSql('ALTER TABLE serologie ADD CONSTRAINT FK_CE81DC69B4D778D5 FOREIGN KEY (greffe_id) REFERENCES greffe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conditionnement_immunologique DROP FOREIGN KEY FK_7C9AFF93B4D778D5');
        $this->addSql('ALTER TABLE groupe_hla DROP FOREIGN KEY FK_C5D8D442B4D778D5');
        $this->addSql('ALTER TABLE prelevement DROP FOREIGN KEY FK_88C8671FB4D778D5');
        $this->addSql('ALTER TABLE serologie DROP FOREIGN KEY FK_CE81DC69B4D778D5');
        $this->addSql('DROP TABLE conditionnement_immunologique');
        $this->addSql('DROP TABLE groupe_hla');
        $this->addSql('DROP TABLE prelevement');
        $this->addSql('DROP TABLE serologie');
    }
}
