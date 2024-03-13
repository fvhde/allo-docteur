<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228185524 extends AbstractMigration
{
    private const CITIES = [
    [
        "name" => "Banfora",
        "latitude" => "10.63333000",
        "longitude" => "-4.76667000",
    ],
    [
        "name" => "Barani",
        "latitude" => "13.16910000",
        "longitude" => "-3.88990000",
    ],
    [
        "name" => "Batié",
        "latitude" => "9.88333000",
        "longitude" => "-2.91667000",
    ],
    [
        "name" => "Bazega Province",
        "latitude" => "11.91667000",
        "longitude" => "-1.50000000",
    ],
    [
        "name" => "Bobo-Dioulasso",
        "latitude" => "11.17715000",
        "longitude" => "-4.29790000",
    ],
    [
        "name" => "Bogandé",
        "latitude" => "12.97040000",
        "longitude" => "-0.14953000",
    ],
    [
        "name" => "Boromo",
        "latitude" => "11.74542000",
        "longitude" => "-2.93006000",
    ],
    [
        "name" => "Boulsa",
        "latitude" => "12.66664000",
        "longitude" => "-0.57469000",
    ],
    [
        "name" => "Boussé",
        "latitude" => "12.66121000",
        "longitude" => "-1.89515000",
    ],
    [
        "name" => "Dano",
        "latitude" => "11.14640000",
        "longitude" => "-3.05784000",
    ],
    [
        "name" => "Dédougou",
        "latitude" => "12.46338000",
        "longitude" => "-3.46075000",
    ],
    [
        "name" => "Diapaga",
        "latitude" => "12.07305000",
        "longitude" => "1.78838000",
    ],
    [
        "name" => "Diébougou",
        "latitude" => "10.96209000",
        "longitude" => "-3.24967000",
    ],
    [
        "name" => "Djibo",
        "latitude" => "14.09940000",
        "longitude" => "-1.62554000",
    ],
    [
        "name" => "Dori",
        "latitude" => "14.03540000",
        "longitude" => "-0.03450000",
    ],
    [
        "name" => "Fada N\'gourma",
        "latitude" => "12.06157000",
        "longitude" => "0.35843000",
    ],
    [
        "name" => "Garango",
        "latitude" => "11.80000000",
        "longitude" => "-0.55056000",
    ],
    [
        "name" => "Gayéri",
        "latitude" => "12.64824000",
        "longitude" => "0.49314000",
    ],
    [
        "name" => "Gnagna Province",
        "latitude" => "12.91880000",
        "longitude" => "0.03920000",
    ],
    [
        "name" => "Gorom-Gorom",
        "latitude" => "14.44290000",
        "longitude" => "-0.23468000",
    ],
    [
        "name" => "Goulouré",
        "latitude" => "12.23484000",
        "longitude" => "-1.93394000",
    ],
    [
        "name" => "Gourcy",
        "latitude" => "13.20776000",
        "longitude" => "-2.35893000",
    ],
    [
        "name" => "Houndé",
        "latitude" => "11.50000000",
        "longitude" => "-3.51667000",
    ],
    [
        "name" => "Kadiogo Province",
        "latitude" => "12.33333000",
        "longitude" => "-1.50000000",
    ],
    [
        "name" => "Kaya",
        "latitude" => "13.09167000",
        "longitude" => "-1.08444000",
    ],
    [
        "name" => "Kokologo",
        "latitude" => "12.19392000",
        "longitude" => "-1.87687000",
    ],
    [
        "name" => "Kombissiri",
        "latitude" => "12.06884000",
        "longitude" => "-1.33644000",
    ],
    [
        "name" => "Kongoussi",
        "latitude" => "13.32583000",
        "longitude" => "-1.53472000",
    ],
    [
        "name" => "Koudougou",
        "latitude" => "12.25263000",
        "longitude" => "-2.36272000",
    ],
    [
        "name" => "Koupéla",
        "latitude" => "12.17864000",
        "longitude" => "-0.35103000",
    ],
    [
        "name" => "Kouritenga Province",
        "latitude" => "12.20000000",
        "longitude" => "-0.30000000",
    ],
    [
        "name" => "Léo",
        "latitude" => "11.10033000",
        "longitude" => "-2.10654000",
    ],
    [
        "name" => "Manga",
        "latitude" => "11.66361000",
        "longitude" => "-1.07306000",
    ],
    [
        "name" => "Nahouri Province",
        "latitude" => "11.25000000",
        "longitude" => "-1.25000000",
    ],
    [
        "name" => "Nouna",
        "latitude" => "12.72939000",
        "longitude" => "-3.86305000",
    ],
    [
        "name" => "Ouagadougou",
        "latitude" => "12.36566000",
        "longitude" => "-1.53388000",
    ],
    [
        "name" => "Ouahigouya",
        "latitude" => "13.58278000",
        "longitude" => "-2.42158000",
    ],
    [
        "name" => "Ouargaye",
        "latitude" => "11.50202000",
        "longitude" => "0.05886000",
    ],
    [
        "name" => "Oubritenga",
        "latitude" => "12.66667000",
        "longitude" => "-1.33333000",
    ],
    [
        "name" => "Pama",
        "latitude" => "11.24972000",
        "longitude" => "0.70750000",
    ],
    [
        "name" => "Pitmoaga",
        "latitude" => "12.24564000",
        "longitude" => "-1.88148000",
    ],
    [
        "name" => "Pô",
        "latitude" => "11.16972000",
        "longitude" => "-1.14500000",
    ],
    [
        "name" => "Province de l’Oudalan",
        "latitude" => "14.66667000",
        "longitude" => "-0.33333000",
    ],
    [
        "name" => "Province de la Bougouriba",
        "latitude" => "10.83333000",
        "longitude" => "-3.41667000",
    ],
    [
        "name" => "Province de la Comoé",
        "latitude" => "10.33333000",
        "longitude" => "-4.41667000",
    ],
    [
        "name" => "Province de la Komandjoari",
        "latitude" => "12.66667000",
        "longitude" => "0.66667000",
    ],
    [
        "name" => "Province de la Kompienga",
        "latitude" => "11.41667000",
        "longitude" => "0.91667000",
    ],
    [
        "name" => "Province de la Kossi",
        "latitude" => "12.91667000",
        "longitude" => "-3.83333000",
    ],
    [
        "name" => "Province de la Léraba",
        "latitude" => "10.66667000",
        "longitude" => "-5.20000000",
    ],
    [
        "name" => "Province de la Sissili",
        "latitude" => "11.33333000",
        "longitude" => "-2.25000000",
    ],
    [
        "name" => "Province de la Tapoa",
        "latitude" => "12.00000000",
        "longitude" => "1.75000000",
    ],
    [
        "name" => "Province des Balé",
        "latitude" => "11.71667000",
        "longitude" => "-3.05000000",
    ],
    [
        "name" => "Province des Banwa",
        "latitude" => "12.16667000",
        "longitude" => "-4.16667000",
    ],
    [
        "name" => "Province du Bam",
        "latitude" => "13.46667000",
        "longitude" => "-1.58333000",
    ],
    [
        "name" => "Province du Boulgou",
        "latitude" => "11.50000000",
        "longitude" => "-0.41667000",
    ],
    [
        "name" => "Province du Boulkiemdé",
        "latitude" => "12.33333000",
        "longitude" => "-2.16667000",
    ],
    [
        "name" => "Province du Ganzourgou",
        "latitude" => "12.26667000",
        "longitude" => "-0.76667000",
    ],
    [
        "name" => "Province du Gourma",
        "latitude" => "12.08333000",
        "longitude" => "0.50000000",
    ],
    [
        "name" => "Province du Houet",
        "latitude" => "11.33333000",
        "longitude" => "-4.25000000",
    ],
    [
        "name" => "Province du Ioba",
        "latitude" => "11.08333000",
        "longitude" => "-3.08333000",
    ],
    [
        "name" => "Province du Kénédougou",
        "latitude" => "11.41667000",
        "longitude" => "-5.00000000",
    ],
    [
        "name" => "Province du Koulpélogo",
        "latitude" => "11.41667000",
        "longitude" => "0.16667000",
    ],
    [
        "name" => "Province du Kourwéogo",
        "latitude" => "12.58333000",
        "longitude" => "-1.76667000",
    ],
    [
        "name" => "Province du Loroum",
        "latitude" => "13.91667000",
        "longitude" => "-2.16667000",
    ],
    [
        "name" => "Province du Mouhoun",
        "latitude" => "12.25000000",
        "longitude" => "-3.41667000",
    ],
    [
        "name" => "Province du Namentenga",
        "latitude" => "13.25000000",
        "longitude" => "-0.50000000",
    ],
    [
        "name" => "Province du Nayala",
        "latitude" => "12.66667000",
        "longitude" => "-3.00000000",
    ],
    [
        "name" => "Province du Noumbièl",
        "latitude" => "9.83333000",
        "longitude" => "-3.00000000",
    ],
    [
        "name" => "Province du Passoré",
        "latitude" => "12.91667000",
        "longitude" => "-2.16667000",
    ],
    [
        "name" => "Province du Poni",
        "latitude" => "10.25000000",
        "longitude" => "-3.41667000",
    ],
    [
        "name" => "Province du Sanguié",
        "latitude" => "12.16667000",
        "longitude" => "-2.66667000",
    ],
    [
        "name" => "Province du Sanmatenga",
        "latitude" => "13.25000000",
        "longitude" => "-1.08333000",
    ],
    [
        "name" => "Province du Séno",
        "latitude" => "13.96400000",
        "longitude" => "0.01200000",
    ],
    [
        "name" => "Province du Soum",
        "latitude" => "14.33333000",
        "longitude" => "-1.25000000",
    ],
    [
        "name" => "Province du Sourou",
        "latitude" => "13.25000000",
        "longitude" => "-3.00000000",
    ],
    [
        "name" => "Province du Tuy",
        "latitude" => "11.41667000",
        "longitude" => "-3.41667000",
    ],
    [
        "name" => "Province du Yagha",
        "latitude" => "13.41667000",
        "longitude" => "0.58333000",
    ],
    [
        "name" => "Province du Yatenga",
        "latitude" => "13.58333000",
        "longitude" => "-2.41667000",
    ],
    [
        "name" => "Province du Ziro",
        "latitude" => "11.58333000",
        "longitude" => "-1.91667000",
    ],
    [
        "name" => "Province du Zondoma",
        "latitude" => "13.18333000",
        "longitude" => "-2.36667000",
    ],
    [
        "name" => "Réo",
        "latitude" => "12.31963000",
        "longitude" => "-2.47094000",
    ],
    [
        "name" => "Salanso",
        "latitude" => "12.17423000",
        "longitude" => "-4.08477000",
    ],
    [
        "name" => "Sapouy",
        "latitude" => "11.55444000",
        "longitude" => "-1.77361000",
    ],
    [
        "name" => "Sindou",
        "latitude" => "10.66667000",
        "longitude" => "-5.16667000",
    ],
    [
        "name" => "Tenkodogo",
        "latitude" => "11.78000000",
        "longitude" => "-0.36972000",
    ],
    [
        "name" => "Titao",
        "latitude" => "13.76667000",
        "longitude" => "-2.06667000",
    ],
    [
        "name" => "Toma",
        "latitude" => "12.75844000",
        "longitude" => "-2.89879000",
    ],
    [
        "name" => "Tougan",
        "latitude" => "13.07250000",
        "longitude" => "-3.06940000",
    ],
    [
        "name" => "Yako",
        "latitude" => "12.95910000",
        "longitude" => "-2.26075000",
    ],
    [
        "name" => "Ziniaré",
        "latitude" => "12.58186000",
        "longitude" => "-1.29710000",
    ],
    [
        "name" => "Zorgo",
        "latitude" => "12.24922000",
        "longitude" => "-0.61527000",
    ],
    [
        "name" => "Zoundweogo Province",
        "latitude" => "11.58333000",
        "longitude" => "-1.00000000",
    ],
];


    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        foreach (self::CITIES as $city) {
            //dd(sprintf('INSERT INTO city(id, name, location) VALUES (\'%s\', \'%s\', GeometryFromText(\'POINT(%s, %s)\'))', Uuid::v4()->toBinary(), $city['name'], floatval($city['latitude']), floatval($city['longitude'])));
            $this->addSql(sprintf('INSERT INTO city(id, name, location) VALUES (UNHEX(REPLACE(UUID(), \'-\', \'\')), \'%s\', ST_GeomFromText(\'POINT(%f, %f)\'))', $city['name'], floatval($city['latitude']), floatval($city['longitude'])));
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
