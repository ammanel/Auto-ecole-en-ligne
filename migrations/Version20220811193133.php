<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220811193133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant_auto_ecole (apprenant_id INT NOT NULL, auto_ecole_id INT NOT NULL, INDEX IDX_627770E2C5697D6D (apprenant_id), INDEX IDX_627770E2B1C987E1 (auto_ecole_id), PRIMARY KEY(apprenant_id, auto_ecole_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE choisir (id INT AUTO_INCREMENT NOT NULL, id_ecole INT NOT NULL, id_apprenant INT NOT NULL, date_inscription DATE NOT NULL, satut TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenant_auto_ecole ADD CONSTRAINT FK_627770E2C5697D6D FOREIGN KEY (apprenant_id) REFERENCES apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apprenant_auto_ecole ADD CONSTRAINT FK_627770E2B1C987E1 FOREIGN KEY (auto_ecole_id) REFERENCES auto_ecole (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE apprenant_auto_ecole');
        $this->addSql('DROP TABLE choisir');
    }
}
