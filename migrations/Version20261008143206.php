<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261008143206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle ADD first_registration_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD current_registration_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD variant_type VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD cnit VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD vin VARCHAR(17) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD max_laden_mass INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD max_combined_mass INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD unladen_mass INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD eu_category VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD national_genre VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD body_type VARCHAR(10) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD type_approval_number VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD engine_displacement INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD net_power_kw DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD fiscal_power SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD seat_count SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD co2_emissions SMALLINT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicle ADD category VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vehicle ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vehicle ALTER brand DROP NOT NULL');
        $this->addSql('ALTER TABLE vehicle ALTER model DROP NOT NULL');
        $this->addSql('ALTER TABLE vehicle RENAME COLUMN year TO energy');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicle DROP first_registration_date');
        $this->addSql('ALTER TABLE vehicle DROP current_registration_date');
        $this->addSql('ALTER TABLE vehicle DROP variant_type');
        $this->addSql('ALTER TABLE vehicle DROP cnit');
        $this->addSql('ALTER TABLE vehicle DROP vin');
        $this->addSql('ALTER TABLE vehicle DROP max_laden_mass');
        $this->addSql('ALTER TABLE vehicle DROP max_combined_mass');
        $this->addSql('ALTER TABLE vehicle DROP unladen_mass');
        $this->addSql('ALTER TABLE vehicle DROP eu_category');
        $this->addSql('ALTER TABLE vehicle DROP national_genre');
        $this->addSql('ALTER TABLE vehicle DROP body_type');
        $this->addSql('ALTER TABLE vehicle DROP type_approval_number');
        $this->addSql('ALTER TABLE vehicle DROP engine_displacement');
        $this->addSql('ALTER TABLE vehicle DROP net_power_kw');
        $this->addSql('ALTER TABLE vehicle DROP fiscal_power');
        $this->addSql('ALTER TABLE vehicle DROP seat_count');
        $this->addSql('ALTER TABLE vehicle DROP co2_emissions');
        $this->addSql('ALTER TABLE vehicle DROP category');
        $this->addSql('ALTER TABLE vehicle DROP status');
        $this->addSql('ALTER TABLE vehicle ALTER brand SET NOT NULL');
        $this->addSql('ALTER TABLE vehicle ALTER model SET NOT NULL');
        $this->addSql('ALTER TABLE vehicle RENAME COLUMN energy TO year');
    }
}
