<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220729135621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, compte_id INT DEFAULT NULL, typedoc_id INT DEFAULT NULL, date_etablissement DATE NOT NULL, INDEX IDX_D8698A76F2C56620 (compte_id), INDEX IDX_D8698A76D6223D7 (typedoc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rappel (id INT AUTO_INCREMENT NOT NULL, id_doc_id INT DEFAULT NULL, date_expiration DATE NOT NULL, INDEX IDX_303A29C9AF61FD51 (id_doc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_document (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, duree INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76F2C56620 FOREIGN KEY (compte_id) REFERENCES apprenant (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76D6223D7 FOREIGN KEY (typedoc_id) REFERENCES type_document (id)');
        $this->addSql('ALTER TABLE rappel ADD CONSTRAINT FK_303A29C9AF61FD51 FOREIGN KEY (id_doc_id) REFERENCES document (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rappel DROP FOREIGN KEY FK_303A29C9AF61FD51');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76D6223D7');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE rappel');
        $this->addSql('DROP TABLE type_document');
    }
}
