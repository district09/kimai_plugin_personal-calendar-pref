<?php

namespace KimaiPlugin\PersonalCalendarPrefBundle\EventSubscriber;

use App\Configuration\SystemConfiguration;
use App\Entity\UserPreference;
use App\Event\UserPreferenceEvent;
use App\Form\Type\DayTimeType;
use App\Validator\Constraints\TimeFormat;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserProfileSubscriber implements EventSubscriberInterface
{
    /**
     * @var SystemConfiguration $configuration
     */
    protected $configuration;

    public function __construct(SystemConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserPreferenceEvent::class => ['loadUserPreferences', 200]
        ];
    }

    public function loadUserPreferences(UserPreferenceEvent $event)
    {
        if (null === ($user = $event->getUser())) {
            return;
        }

        // You attach every field to the event and all the heavy lifting is done by Kimai.
        // The value is the default as long as the user has not yet updated his preferences,
        // otherwise it will be overwritten with the users choice, stored in the database.
        $event->addPreference(
            (new UserPreference('calendar_visibleHours_begin'))
                ->setValue($this->configuration->getCalendarTimeframeBegin())
                ->setType(DayTimeType::class)
                ->setConstraints([new NotBlank(), new TimeFormat()]),
        );

        $event->addPreference(
            (new UserPreference('calendar_visibleHours_end'))
                ->setValue($this->configuration->getCalendarTimeframeEnd())
                ->setType(DayTimeType::class)
                ->setConstraints([new NotBlank(), new TimeFormat()]),
        );
    }
}
