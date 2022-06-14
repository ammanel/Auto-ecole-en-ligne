<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220604235540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_leçon DROP FOREIGN KEY FK_761D64296422100F');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E6422100F');
        $this->addSql('CREATE TABLE apprenant_apprenant (apprenant_source INT NOT NULL, apprenant_target INT NOT NULL, INDEX IDX_93832C724611BCDF (apprenant_source), INDEX IDX_93832C725FF4EC50 (apprenant_target), PRIMARY KEY(apprenant_source, apprenant_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu_cours LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenant_apprenant ADD CONSTRAINT FK_93832C724611BCDF FOREIGN KEY (apprenant_source) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_apprenant ADD CONSTRAINT FK_93832C725FF4EC50 FOREIGN KEY (apprenant_target) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE apprenant_leçon');
        $this->addSql('DROP TABLE leçon');
        $this->addSql('DROP INDEX IDX_B6F7494E6422100F ON question');
        $this->addSql('ALTER TABLE question DROP leçon_id');
        $this->addSql('ALTER TABLE question_proposition DROP isGood');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant_leçon (apprenant_id INT NOT NULL, leçon_id INT NOT NULL, INDEX IDX_761D6429C5697D6D (apprenant_id), INDEX IDX_761D64296422100F (leçon_id), PRIMARY KEY(apprenant_id, leçon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE leçon (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, contenu_cours LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apprenant_leçon ADD CONSTRAINT FK_761D64296422100F FOREIGN KEY (leçon_id) REFERENCES leçon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_leçon ADD CONSTRAINT FK_761D6429C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE apprenant_apprenant');
        $this->addSql('DROP TABLE cours');
        $this->addSql('ALTER TABLE question ADD leçon_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E6422100F FOREIGN KEY (leçon_id) REFERENCES leçon (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E6422100F ON question (leçon_id)');
        $this->addSql('ALTER TABLE question_proposition ADD isGood TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
