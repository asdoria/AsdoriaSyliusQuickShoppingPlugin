<?php

declare(strict_types=1);

namespace Asdoria\SyliusQuickShoppingPlugin\EventListener;

//use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\Metadata\StaticPropertyMetadata;
use JMS\Serializer\Metadata\VirtualPropertyMetadata;

/**
 * Class AbstractEntitySubscriber
 */
abstract class AbstractEntitySubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ['event' => Events::POST_SERIALIZE, 'method' => 'onPostSerialize', 'priority' => 500, 'class' => static::getClassName()],
        ];
    }

    public function onPostSerialize(ObjectEvent $event): void
    {
        foreach ($this->getMethodNames() as $methodName) {
            /** @var JsonSerializationVisitor $visitor */
            $visitor = $event->getVisitor();
            $metadata = new VirtualPropertyMetadata(static::getClassName(), $methodName);

            if (!$visitor->hasData($metadata->name)) {
                $value = $this->{$methodName}($event->getObject());
                $visitor->visitProperty(
                    new StaticPropertyMetadata(static::getClassName(), $metadata->name, $value),
                    $value,
                );
            }
        }
    }

    abstract protected static function getClassName(): string;

    abstract protected function getMethodNames(): array;
}
