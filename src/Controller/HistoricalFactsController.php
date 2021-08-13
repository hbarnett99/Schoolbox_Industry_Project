<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

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
        $path = $this->request->getPath();
        $userEmail = $this->request->getSession()->read('Auth.email');
        if ($userEmail == null) {
            $this->redirect('/users/login?redirect=' . $path);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $historicalFacts = $this->paginate($this->HistoricalFacts);

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
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $historicalFact = $this->HistoricalFacts->newEmptyEntity();
        if ($this->request->is('post')) {
            $historicalFact = $this->HistoricalFacts->patchEntity($historicalFact, $this->request->getData());
            if ($this->HistoricalFacts->save($historicalFact)) {
                $this->Flash->success(__('The historical fact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The historical fact could not be saved. Please, try again.'));
        }
        $this->set(compact('historicalFact'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Historical Fact id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $historicalFact = $this->HistoricalFacts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $historicalFact = $this->HistoricalFacts->patchEntity($historicalFact, $this->request->getData());
            if ($this->HistoricalFacts->save($historicalFact)) {
                $this->Flash->success(__('The historical fact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The historical fact could not be saved. Please, try again.'));
        }
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
}
