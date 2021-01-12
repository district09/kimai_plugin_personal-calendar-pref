<?php

/*
 * This file is part of the Kimai PersonalCalendarPrefBundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\PersonalCalendarPrefBundle\Controller;

use App\Configuration\SystemConfiguration;
use App\Controller\CalendarController as CallendarControllerBase;
use App\Repository\TimesheetRepository;
use App\Timesheet\TrackingModeService;
use Ckr\Util\ArrayMerger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to display calendars.
 *
 * @Route(path="/calendar")
 * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
 */
class CalendarController extends CallendarControllerBase
{
    /**
     * @var array
     */
    protected $userPreferenceOverrides = [];

    /**
     * @Route(path="/", name="calendar", methods={"GET"})
     */
    public function userCalendar(SystemConfiguration $configuration, TrackingModeService $service, TimesheetRepository $repository)
    {
        $user = $this->getUser();
        $timeframeBegin = $user->getPreferenceValue('calendar.visibleHours.begin', $configuration->getCalendarTimeframeBegin());
        $timeframeEnd = $user->getPreferenceValue('calendar.visibleHours.end', $configuration->getCalendarTimeframeEnd());
        $this->userPreferenceOverrides = [
            'config' => [
                'timeframeBegin' => $timeframeBegin,
                'timeframeEnd' => $timeframeEnd,
            ]
        ];

        return parent::userCalendar($configuration, $service, $repository);
    }

    protected function render(string $view, array $parameters = array(), Response $response = null): Response
    {
        $parameters = (new ArrayMerger($parameters, $this->userPreferenceOverrides))->mergeData();

        return parent::render($view, $parameters, $response);
    }
}
