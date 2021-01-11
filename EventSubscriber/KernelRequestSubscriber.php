<?php

namespace KimaiPlugin\PersonalCalendarPrefBundle\EventSubscriber;

use KimaiPlugin\PersonalCalendarPrefBundle\Controller\CalendarController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(EventDispatcherInterface $dispatcher, ContainerInterface $container)
    {
        $this->dispatcher = $dispatcher;
        $this->container = $container;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['onKernelController', 200]
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        if (is_array($controller) && get_class($controller[0]) === \App\Controller\CalendarController::class) {
            $controller[0] = new CalendarController($this->dispatcher);
            $controller[0]->setContainer($this->container);
            $event->setController($controller);
        }
    }
}
