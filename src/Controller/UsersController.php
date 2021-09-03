<?php
declare(strict_types=1);

namespace App\Controller;

use \Cake\Event\EventInterface;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $path = $this->request->getPath();
        //debug($this->getRequest()); die;
        $userEmail = $this->request->getSession()->read('Auth.email');
        if ($userEmail == null && $path != "/users/login" && $path != "/") {
            //$this->Flash->error("Please sign in first...");
            if ($path != "/users/logout") {
                $this->redirect('/users/login?redirect=' . $path);
            }
        }

        $this->checkIfLoggedIn();
    }

    /**
     * Login route, powered by ADmad's cakephp-social-auth plugin
     */
    public function login() {
        // This is a stub that has to be here for the route to connect.
        $this->viewBuilder()->setLayout('login');
    }

    /**
     * Logout route. Deletes the Auth value from the session storage.
     * @return \Cake\Http\Response|null
     */
    public function logout() {
        $this->request->allowMethod(['get']);
        $this->request->getSession()->delete("Auth");
        $this->Flash->success("Signed out successfully!");

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

    public function checkIfLoggedIn(){
        if ($this->request->getSession()->read('Auth.email') != null) {
            return $this->redirect(['controller' => 'HistoricalFacts', 'action' => 'newestData']);
        }
    }

}
