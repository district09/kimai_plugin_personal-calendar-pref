<?php

namespace KimaiPlugin\PersonalCalendarPrefBundle\Command;

use App\Command\AbstractBundleInstallerCommand;

class InstallCommand extends AbstractBundleInstallerCommand
{
    protected function getBundleCommandNamePart(): string
    {
        return 'personalcalendarpref';
    }

    protected function getMigrationConfigFilename(): ?string
    {
        return __DIR__ . '/../Migrations/personalcalendarpref.yaml';
    }
}
