<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819182105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE choisir ADD id_ecole_id INT DEFAULT NULL, DROP id_ecole');
        $this->addSql('ALTER TABLE choisir ADD CONSTRAINT FK_C25A4AD32734F78B FOREIGN KEY (id_ecole_id) REFERENCES auto_ecole (id)');
        $this->addSql('CREATE INDEX IDX_C25A4AD32734F78B ON choisir (id_ecole_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE choisir DROP FOREIGN KEY FK_C25A4AD32734F78B');
        $this->addSql('DROP INDEX IDX_C25A4AD32734F78B ON choisir');
        $this->addSql('ALTER TABLE choisir ADD id_ecole INT NOT NULL, DROP id_ecole_id');
    }
}
