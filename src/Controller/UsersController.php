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
        $userEmail = $this->request->getSession()->read('Auth.email');
        if ($userEmail == null && $path != "/users/login" && $path != "/") {
            if ($path != "/users/logout") {
                $this->Flash->error("Please sign in first...");
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
		
		// !!! WARNING !!! - THIS IS A TEST VERSION OF THE CODE THAT DISABLES LOGIN FUNCTIONALITY
		// NEVER USE THIS IN ANY KIND OF PRODUCTION ENVIRONMENT
		$this->request->getSession()->write('Auth.email', 'fakeemail@gmail.com');
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
            if ($this->request->getPath() != '/users/logout') {
                return $this->redirect(['controller' => 'HistoricalFacts', 'action' => 'newestData']);
            }
        }
    }

}
