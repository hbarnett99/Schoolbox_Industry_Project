<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Facts Controller
 */
class CompareFactsController extends AppController
{

    /**
     * Check to see if the user is signed in first
     * @param EventInterface $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Capture query params if passed
        $queryString = '?';
        foreach ($this->request->getQueryParams() as $key => $value) {
            $queryString .= $key . '=' . $value . '&';
        }
        $queryString = Substr_replace($queryString, "", -1);

        $path = $this->request->getPath();
        $userEmail = $this->request->getSession()->read('Auth.email');
        if ($userEmail == null) {
            $this->Flash->error("Please sign in first...");
            $this->redirect('/users/login?redirect=' . $path . $queryString);
        }
    }

    /**
     * Index method
     */
    public function index()
    {
        // Redirect index controller to compare
        $this->redirect(['action' => 'compare']);
    }

    public function compare() {

    }
}
