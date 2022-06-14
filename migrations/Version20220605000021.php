<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605000021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant_cours (apprenant_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_A3F510AC5697D6D (apprenant_id), INDEX IDX_A3F510A7ECF78B0 (cours_id), PRIMARY KEY(apprenant_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenant_cours ADD CONSTRAINT FK_A3F510AC5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_cours ADD CONSTRAINT FK_A3F510A7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE apprenant_apprenant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant_apprenant (apprenant_source INT NOT NULL, apprenant_target INT NOT NULL, INDEX IDX_93832C724611BCDF (apprenant_source), INDEX IDX_93832C725FF4EC50 (apprenant_target), PRIMARY KEY(apprenant_source, apprenant_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE apprenant_apprenant ADD CONSTRAINT FK_93832C725FF4EC50 FOREIGN KEY (apprenant_target) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_apprenant ADD CONSTRAINT FK_93832C724611BCDF FOREIGN KEY (apprenant_source) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE apprenant_cours');
    }
}
