<?php

namespace KimaiPlugin\PersonalCalendarPrefBundle\EventSubscriber;

use App\Entity\User;
use App\Event\CalendarConfigurationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface $tokenStorage
     */
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CalendarConfigurationEvent::class => ['alterCalendarConfiguration', 200]
        ];
    }

    public function alterCalendarConfiguration(CalendarConfigurationEvent $event)
    {
        if (null === ($user = $this->getUser())) {
            return;
        }

        $configuration = $event->getConfiguration();
        $overriddenConfig = [
          'timeframeBegin' => $user->getPreferenceValue('calendar.visibleHours.begin', $configuration['timeframeBegin']),
          'timeframeEnd' => $user->getPreferenceValue('calendar.visibleHours.end', $configuration['timeframeEnd']),
        ];

    }

    protected function getUser(): ?User
    {
        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        if (!\is_object($user = $token->getUser()) || !($user instanceof User)) {
            // e.g. anonymous authentication
            return null;
        }

        return $user;
    }
}
