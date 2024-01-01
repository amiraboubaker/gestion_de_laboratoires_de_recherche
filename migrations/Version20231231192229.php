<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231231192229 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE researcher_project DROP FOREIGN KEY FK_218D30FC7533BDE');
        $this->addSql('ALTER TABLE researcher_project DROP FOREIGN KEY FK_218D30F166D1F9C');
        $this->addSql('DROP TABLE researcher_project');
        $this->addSql('ALTER TABLE equipement DROP publications');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677986DD11CD');
        $this->addSql('DROP INDEX IDX_AF3C677986DD11CD ON publication');
        $this->addSql('ALTER TABLE publication DROP researchers_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE researcher_project (researcher_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_218D30FC7533BDE (researcher_id), INDEX IDX_218D30F166D1F9C (project_id), PRIMARY KEY(researcher_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE researcher_project ADD CONSTRAINT FK_218D30FC7533BDE FOREIGN KEY (researcher_id) REFERENCES researcher (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE researcher_project ADD CONSTRAINT FK_218D30F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE publication ADD researchers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677986DD11CD FOREIGN KEY (researchers_id) REFERENCES researcher (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_AF3C677986DD11CD ON publication (researchers_id)');
        $this->addSql('ALTER TABLE equipement ADD publications LONGTEXT NOT NULL');
    }
}
