<?php

declare(strict_types=1);

namespace App\EventSubscriber\Admin\Calendar;

use App\Repository\AppointmentRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class CalendarSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private AppointmentRepository $repository,
        private UrlGeneratorInterface $generator
    )
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar): void
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $appointments = $this->repository
            ->createQueryBuilder('appointment')
            ->where('appointment.beginAt BETWEEN :start and :end OR appointment.endAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($appointments as $appointment) {
            $event = new Event((string) $appointment, $appointment->getBeginAt(), $appointment->getEndAt());

            $event->setOptions(['backgroundColor' => 'red', 'borderColor' => 'red']);
            $event->addOption(
                'url',
                $this->generator->generate('app_booking_show', [
                    'id' => $appointment->getId(),
                ])
            );

            $calendar->addEvent($event);
        }
    }
}