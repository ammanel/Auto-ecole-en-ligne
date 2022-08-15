<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220813041644 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, envoyer_par_id INT DEFAULT NULL, recu_par_id INT DEFAULT NULL, contenu VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, INDEX IDX_B6BD307FF58D4A84 (envoyer_par_id), INDEX IDX_B6BD307F59820928 (recu_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF58D4A84 FOREIGN KEY (envoyer_par_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F59820928 FOREIGN KEY (recu_par_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY document_ibfk_1');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76B4B78D97 FOREIGN KEY (rappel_id_id) REFERENCES rappel (id)');
        $this->addSql('ALTER TABLE rappel DROP FOREIGN KEY rappel_ibfk_1');
        $this->addSql('ALTER TABLE rappel ADD CONSTRAINT FK_303A29C9AF61FD51 FOREIGN KEY (id_doc_id) REFERENCES document (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE message');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76B4B78D97');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT document_ibfk_1 FOREIGN KEY (rappel_id_id) REFERENCES rappel (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rappel DROP FOREIGN KEY FK_303A29C9AF61FD51');
        $this->addSql('ALTER TABLE rappel ADD CONSTRAINT rappel_ibfk_1 FOREIGN KEY (id_doc_id) REFERENCES type_document (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
