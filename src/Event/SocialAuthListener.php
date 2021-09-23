<?php

namespace App\Event;

use ADmad\SocialAuth\Middleware\SocialAuthMiddleware;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Event\EventListenerInterface;
use Cake\Http\Session;

class SocialAuthListener implements EventListenerInterface
{

    public function implementedEvents(): array
    {
        return [
            SocialAuthMiddleware::EVENT_AFTER_IDENTIFY => 'afterIdentify'
        ];
    }

    /**
     * Event Callback for SocialAuth::EVENT_AFTER_IDENTIFY
     * @param EventInterface $event
     * @param EntityInterface $user
     * @return EntityInterface
     */
    public function afterIdentify(EventInterface $event, EntityInterface $user): EntityInterface
    {
        // Obtain a CakePHP session object and write isAdmin to the Auth.User object
        $session = new Session();
        $session->write('Auth.User.isAdmin', $user->isAdmin);

        // Return the user object back to SocialAuth
        return $user;
    }
}
