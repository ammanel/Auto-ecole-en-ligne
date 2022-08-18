<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220818205358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY message_ibfk_1');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY message_ibfk_2');
        $this->addSql('ALTER TABLE message DROP date_envoi');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF58D4A84 FOREIGN KEY (envoyer_par_id) REFERENCES personne (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F59820928 FOREIGN KEY (recu_par_id) REFERENCES personne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF58D4A84');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F59820928');
        $this->addSql('ALTER TABLE message ADD date_envoi DATETIME NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT message_ibfk_1 FOREIGN KEY (envoyer_par_id) REFERENCES personne (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT message_ibfk_2 FOREIGN KEY (recu_par_id) REFERENCES personne (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
