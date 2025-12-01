<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LogSubscriber implements EventSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        // When a controller class defines multiple action methods, the controller
        // is returned as [$controllerInstance, 'methodName']
        if (is_array($controller)) {
            $controller = get_class($controller[0]) . '::' . $controller[1];
        } elseif (is_object($controller)) {
            $controller = get_class($controller);
        } else {
            $controller = (string) $controller;
        }

        $request = $event->getRequest();
        $method = $request->getMethod();
        $uri = $request->getRequestUri();
        $clientIp = $request->getClientIp();

        $this->logger->info(sprintf('Action called: %s [%s] %s (IP: %s)', $controller, $method, $uri, $clientIp));
    }
}
