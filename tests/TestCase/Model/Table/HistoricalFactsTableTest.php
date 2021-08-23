<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HistoricalFactsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HistoricalFactsTable Test Case
 */
class HistoricalFactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HistoricalFactsTable
     */
    protected $HistoricalFacts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.HistoricalFacts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('HistoricalFacts') ? [] : ['className' => HistoricalFactsTable::class];
        $this->HistoricalFacts = $this->getTableLocator()->get('HistoricalFacts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->HistoricalFacts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\HistoricalFactsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
