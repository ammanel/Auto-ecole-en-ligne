<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819181847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE choisir ADD id_apprenant_id INT DEFAULT NULL, DROP id_apprenant');
        $this->addSql('ALTER TABLE choisir ADD CONSTRAINT FK_C25A4AD3E6A8081F FOREIGN KEY (id_apprenant_id) REFERENCES apprenant (id)');
        $this->addSql('CREATE INDEX IDX_C25A4AD3E6A8081F ON choisir (id_apprenant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE choisir DROP FOREIGN KEY FK_C25A4AD3E6A8081F');
        $this->addSql('DROP INDEX IDX_C25A4AD3E6A8081F ON choisir');
        $this->addSql('ALTER TABLE choisir ADD id_apprenant INT NOT NULL, DROP id_apprenant_id');
    }
}
