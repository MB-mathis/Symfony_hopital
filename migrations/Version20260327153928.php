<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260327153928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_user_share (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_BB04C0ED6B899279 (patient_id), INDEX IDX_BB04C0EDA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE patient_user_share ADD CONSTRAINT FK_BB04C0ED6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient_user_share ADD CONSTRAINT FK_BB04C0EDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE patient_user DROP FOREIGN KEY `FK_4029B816B899279`');
        $this->addSql('ALTER TABLE patient_user DROP FOREIGN KEY `FK_4029B81A76ED395`');
        $this->addSql('DROP TABLE patient_user');
        $this->addSql('ALTER TABLE patient CHANGE update_at updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE patient_user (patient_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4029B816B899279 (patient_id), INDEX IDX_4029B81A76ED395 (user_id), PRIMARY KEY (patient_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE patient_user ADD CONSTRAINT `FK_4029B816B899279` FOREIGN KEY (patient_id) REFERENCES patient (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_user ADD CONSTRAINT `FK_4029B81A76ED395` FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient_user_share DROP FOREIGN KEY FK_BB04C0ED6B899279');
        $this->addSql('ALTER TABLE patient_user_share DROP FOREIGN KEY FK_BB04C0EDA76ED395');
        $this->addSql('DROP TABLE patient_user_share');
        $this->addSql('ALTER TABLE patient CHANGE updated_at update_at DATETIME DEFAULT NULL');
    }
}
