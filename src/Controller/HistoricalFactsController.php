<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;

/**
 * HistoricalFacts Controller
 *
 * @property \App\Model\Table\HistoricalFactsTable $HistoricalFacts
 * @method \App\Model\Entity\HistoricalFact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class HistoricalFactsController extends AppController
{

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->loadModel('HistoricalFacts');

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
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $historicalFacts = $this->paginate($this->HistoricalFacts, [
            'order' => ['HistoricalFacts.id' => 'desc']
        ]);

        $this->set(compact('historicalFacts'));
    }

    /**
     * View method
     *
     * @param string|null $id Historical Fact id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $historicalFact = $this->HistoricalFacts->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('historicalFact'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Historical Fact id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $historicalFact = $this->HistoricalFacts->get($id);
        if ($this->HistoricalFacts->delete($historicalFact)) {
            $this->Flash->success(__('The historical fact has been deleted.'));
        } else {
            $this->Flash->error(__('The historical fact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Newest Data Method
     *
     * Retrieves the newest entry in the DB
     */
    public function newestData() {
        $historicalFact = $this->HistoricalFacts->find('all', [
            'order' => ['id' => 'DESC']
        ]);

        // Get the first item in the list
        $historicalFact = $historicalFact->first();

        // Display a flash message when showing the most recent dataset
        $this->Flash->success("You are viewing the most up-to-date dataset!");

        $this->set(compact('historicalFact'));
        $this->render('view');
    }
}
