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

    public function checkIfLoggedIn() {
        if ($this->request->getSession()->read('Auth.email') != null) {
            if ($this->request->getPath() != '/users/logout' && $this->request->getPath() != '/users' && (strpos($this->request->getPath(), '/users/edit/') !== 0)) {
                return $this->redirect(['controller' => 'HistoricalFacts', 'action' => 'newestData']);
            }
        }
    }

    /**
     * Index Method
     */
    public function index() {
        // Ensure that only admin users can access the users list
        if ($this->getRequest()->getSession()->read('Auth.isAdmin')) {
            $users = $this->paginate($this->Users);

            $this->set(compact('users'));
        } else {
            $this->Flash->error("You must be an administrator to view this page!");
            $this->redirect(['controller' => 'HistoricalFacts', 'action' => 'newestData']);
        }
    }

    /**
     * Edit method for a user - changes a user's type
     * @param null $id the ID of the user to be changed
     * @param null $change a string representing the change to be made (either makeAdmin or makeUser)
     */
    public function edit($id = null, $change = null) {

        $this->request->allowMethod('GET');

        // Ensure that currently signed-in user is an admin before continuing
        if ($this->getRequest()->getSession()->read('Auth.isAdmin')) {
            // If the currently signed-in user is attempting to change their own details, then redirect with an error
            if ($id == $this->getRequest()->getSession()->read('Auth.id')) {
                $this->Flash->error("You cannot edit your own account's details!");
            } else {
                // Change the user type based on the provided $change variable
                $user = $this->Users->get($id);
                if ($change == "makeAdmin") {
                    $user->isAdmin = 1;
                } else if ($change == "makeUser") {
                    $user->isAdmin = 0;
                }

                // Attempt to save changes to the user.
                if ($this->Users->save($user)) {
                    $this->Flash->success("Successfully updated user  '" . $user->email . "'!");
                } else {
                    $this->Flash->error("Failed to update user '" .  $user->email . "'. Please try again!");
                }
            }
        } else {
            $this->Flash->error("Changing a user's type can only be performed by an Administrator. If you think this is an error, please contact an administrator.");
        }

        $this->redirect(['action' => 'index']);
    }

}
