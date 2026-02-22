<?php

namespace Domains\Events\Traits;

use Domains\Events\Contracts\DomainEventInterface;

trait EventBag
{
    /** @var DomainEventInterface[] */
    private array $events = [];

    /**
     * @param DomainEventInterface $event
     * @return void
     */
    protected function addEvent(DomainEventInterface $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return array
     */
    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->events = [];

        return $events;
    }
}
