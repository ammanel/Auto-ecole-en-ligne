<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605141210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_cours DROP note');
        $this->addSql('ALTER TABLE cours ADD enable TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD enable TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE proposition ADD enable TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD enable TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_cours ADD note INT NOT NULL');
        $this->addSql('ALTER TABLE cours DROP enable');
        $this->addSql('ALTER TABLE personne DROP enable');
        $this->addSql('ALTER TABLE proposition DROP enable');
        $this->addSql('ALTER TABLE question DROP enable');
    }
}
