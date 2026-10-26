<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261008100532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle ADD registration_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vehicle ADD year VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD color VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle DROP registration_number');
        $this->addSql('ALTER TABLE vehicle DROP year');
        $this->addSql('ALTER TABLE vehicle DROP color');
    }
}
