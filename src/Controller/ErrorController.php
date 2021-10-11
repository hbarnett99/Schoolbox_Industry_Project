<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.4
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Error Handling Controller
 *
 * Controller used by ExceptionRenderer to render error responses.
 */
class ErrorController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadComponent('RequestHandler');
    }

    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeFilter(EventInterface $event)
    {
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);

        /**
         * Note about the below nonsense:
         *
         * CakePHP's ErrorController doesn't actually call beforeFilter at all. You can confirm this by
         * running any command (even something as simple as die('hello')); from within it, and seeing nothing.
         *
         * As a result, ErrorController will completely ignore beforeFilter() in any controller (meaning that
         * error messages are shown within forcing someone to login first)
         *
         * This has been known as an oversight(?) since at least 2009 - check out the blog post below:
         * https://www.brade.zone/2009/05/21/cakephp-beforefilter-and-the-error-error/
         *
         * In order to ensure that any internal error messages only show to logged-in users, we need to run
         * a beforeFilter() somewhere, and this is the only place within ErrorController that can access
         * the $this object.
         *
         * Hence, this is a copy-paste nightmare. Blame CakePHP, not me.
         *
         * - Dane R, 09/10/2021
         */
        
        // If the request is a 500 error, then effectively simulate a beforeFilter() in a regular controller
        if ($this->getResponse()->getStatusCode() === 500) {
            // Capture query params if passed
            $queryString = '?';
            foreach ($this->request->getQueryParams() as $key => $value) {
                $queryString .= $key . '=' . $value . '&';
            }
            $queryString = Substr_replace($queryString, "", -1);

            $path = $this->request->getPath();
            $userEmail = $this->request->getSession()->read('Auth.email');
            if ($userEmail == null) {
                $this->request->getFlash()->error("Please sign in first...");
                $this->redirect('/users/login?redirect=' . $path . $queryString);
            }
        }

        $this->viewBuilder()->setTemplatePath('Error');
    }

    /**
     * afterFilter callback.
     *
     * @param \Cake\Event\EventInterface $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function afterFilter(EventInterface $event)
    {
    }
}
