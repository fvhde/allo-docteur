<?php

declare(strict_types=1);

namespace App\EventSubscriber\Admin\Action;

use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminCrudActionSubscriber implements EventSubscriberInterface
{
    private Session $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityPersistedEvent::class => ['flashMessageAfterPersist'],
            AfterEntityUpdatedEvent::class => ['flashMessageAfterUpdate'],
            AfterEntityDeletedEvent::class => ['flashMessageAfterDelete'],
        ];
    }

    public function flashMessageAfterPersist(AfterEntityPersistedEvent $event): void
    {
        $this->session->getFlashBag()->add('success', (string) $event->getEntityInstance(). ' crée');
    }

    public function flashMessageAfterUpdate(AfterEntityUpdatedEvent $event): void
    {
        $this->session->getFlashBag()->add('success', (string) $event->getEntityInstance(). ' mis à jour');
    }

    public function flashMessageAfterDelete(AfterEntityDeletedEvent $event): void
    {
        $this->session->getFlashBag()->add('success', (string) $event->getEntityInstance(). ' supprimé');
    }
}