<?php

declare(strict_types=1);

namespace KimaiPlugin\PersonalCalendarPrefBundle\Migrations;

use App\Doctrine\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * @version 2.0.0
 */
final class Version20230616095926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Corrects the user preference name';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("UPDATE kimai2_user_preferences SET `name` = 'calendar_visibleHours_begin' WHERE `name` = 'calendar.visibleHours.begin'");
        $this->addSql("UPDATE kimai2_user_preferences SET `name` = 'calendar_visibleHours_end' WHERE `name` = 'calendar.visibleHours.end'");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("UPDATE kimai2_user_preferences SET `name` = 'calendar.visibleHours.begin' WHERE `name` = 'calendar_visibleHours_begin'");
        $this->addSql("UPDATE kimai2_user_preferences SET `name` = 'calendar.visibleHours.end' WHERE `name` = 'calendar_visibleHours_end'");
    }
}
