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
        $userEmail = $this->request->getSession()->read('Auth.email');
        if ($userEmail == null) {
            $this->Flash->error("Please sign in first...");
            $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }
    }

    /**
     * Logout route. Deletes the Auth value from the session storage.
     * @return \Cake\Http\Response|null
     */
    public function logout() {
        $this->request->allowMethod(['get']);
        $this->request->getSession()->delete("Auth");
        $this->Flash->success("Signed out successfully!");

        return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
    }

}
