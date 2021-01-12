# PersonalCalendarPrefBundle

A Kimai 2 plugin, which allows users to set a customized start and end time for
the calendar display in their personal preferences.

## Installation

First clone it to your Kimai installation `plugins` directory:
```
cd /kimai/var/plugins/
git clone https://github.com/digipolisgent/kimai_plugin_personal-calendar-pref.git PersonalCalendarPrefBundle
```

And then rebuild the cache:
```
cd /kimai/
bin/console cache:clear
bin/console cache:warmup
```

You could also [download it as zip](https://github.com/digipolisgent/kimai_plugin_personal-calendar-pref/archive/master.zip) and upload the directory via FTP:

```
/kimai/var/plugins/
├── PersonalCalendarPrefBundle
│   ├── PersonalCalendarPrefBundle.php
|   └ ... more files and directories follow here ...
```
