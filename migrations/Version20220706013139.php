<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220706013139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_cours DROP note');
        $this->addSql('ALTER TABLE question ADD cours_dedie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EBD26FFD4 FOREIGN KEY (cours_dedie_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EBD26FFD4 ON question (cours_dedie_id)');
        $this->addSql('ALTER TABLE question_proposition DROP isGood');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE apprenant_cours ADD note INT NOT NULL');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EBD26FFD4');
        $this->addSql('DROP INDEX IDX_B6F7494EBD26FFD4 ON question');
        $this->addSql('ALTER TABLE question DROP cours_dedie_id');
        $this->addSql('ALTER TABLE question_proposition ADD isGood TINYINT(1) DEFAULT 0');
    }
}
