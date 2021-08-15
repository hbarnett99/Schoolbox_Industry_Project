<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HistoricalFacts Model
 *
 * @method \App\Model\Entity\HistoricalFact newEmptyEntity()
 * @method \App\Model\Entity\HistoricalFact newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\HistoricalFact[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\HistoricalFact get($primaryKey, $options = [])
 * @method \App\Model\Entity\HistoricalFact findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\HistoricalFact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\HistoricalFact[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\HistoricalFact|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HistoricalFact saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\HistoricalFact[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HistoricalFact[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\HistoricalFact[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\HistoricalFact[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class HistoricalFactsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('historical_facts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->dateTime('timestamp')
            ->requirePresence('timestamp', 'create')
            ->notEmptyDateTime('timestamp');

        $validator
            ->scalar('schoolbox_totalusers')
            ->maxLength('schoolbox_totalusers', 4294967295)
            ->requirePresence('schoolbox_totalusers', 'create')
            ->notEmptyString('schoolbox_totalusers');

        $validator
            ->scalar('schoolbox_config_site_type')
            ->maxLength('schoolbox_config_site_type', 4294967295)
            ->requirePresence('schoolbox_config_site_type', 'create')
            ->notEmptyString('schoolbox_config_site_type');

        $validator
            ->scalar('schoolbox_users_student')
            ->maxLength('schoolbox_users_student', 4294967295)
            ->requirePresence('schoolbox_users_student', 'create')
            ->notEmptyString('schoolbox_users_student');

        $validator
            ->scalar('schoolbox_users_staff')
            ->maxLength('schoolbox_users_staff', 4294967295)
            ->requirePresence('schoolbox_users_staff', 'create')
            ->notEmptyString('schoolbox_users_staff');

        $validator
            ->scalar('schoolbox_users_parent')
            ->maxLength('schoolbox_users_parent', 4294967295)
            ->requirePresence('schoolbox_users_parent', 'create')
            ->notEmptyString('schoolbox_users_parent');

        $validator
            ->scalar('schoolbox_totalcampus')
            ->maxLength('schoolbox_totalcampus', 4294967295)
            ->requirePresence('schoolbox_totalcampus', 'create')
            ->notEmptyString('schoolbox_totalcampus');

        $validator
            ->scalar('schoolbox_package_version')
            ->maxLength('schoolbox_package_version', 4294967295)
            ->requirePresence('schoolbox_package_version', 'create')
            ->notEmptyString('schoolbox_package_version');

        $validator
            ->scalar('schoolboxdev_package_version')
            ->maxLength('schoolboxdev_package_version', 4294967295)
            ->requirePresence('schoolboxdev_package_version', 'create')
            ->notEmptyString('schoolboxdev_package_version');

        $validator
            ->scalar('schoolbox_config_site_version')
            ->maxLength('schoolbox_config_site_version', 4294967295)
            ->requirePresence('schoolbox_config_site_version', 'create')
            ->notEmptyString('schoolbox_config_site_version');

        $validator
            ->scalar('virtual')
            ->maxLength('virtual', 4294967295)
            ->requirePresence('virtual', 'create')
            ->notEmptyString('virtual');

        $validator
            ->scalar('lsbdistdescription')
            ->maxLength('lsbdistdescription', 4294967295)
            ->requirePresence('lsbdistdescription', 'create')
            ->notEmptyString('lsbdistdescription');

        $validator
            ->scalar('kernelmajversion')
            ->maxLength('kernelmajversion', 4294967295)
            ->requirePresence('kernelmajversion', 'create')
            ->notEmptyString('kernelmajversion');

        $validator
            ->scalar('kernelrelease')
            ->maxLength('kernelrelease', 4294967295)
            ->requirePresence('kernelrelease', 'create')
            ->notEmptyString('kernelrelease');

        $validator
            ->scalar('php_cli_version')
            ->maxLength('php_cli_version', 4294967295)
            ->requirePresence('php_cli_version', 'create')
            ->notEmptyString('php_cli_version');

        $validator
            ->scalar('mysql_extra_version')
            ->maxLength('mysql_extra_version', 4294967295)
            ->requirePresence('mysql_extra_version', 'create')
            ->notEmptyString('mysql_extra_version');

        $validator
            ->scalar('processorcount')
            ->maxLength('processorcount', 4294967295)
            ->requirePresence('processorcount', 'create')
            ->notEmptyString('processorcount');

        $validator
            ->scalar('memorysize')
            ->maxLength('memorysize', 4294967295)
            ->requirePresence('memorysize', 'create')
            ->notEmptyString('memorysize');

        $validator
            ->scalar('schoolbox_config_date_timezone')
            ->maxLength('schoolbox_config_date_timezone', 4294967295)
            ->requirePresence('schoolbox_config_date_timezone', 'create')
            ->notEmptyString('schoolbox_config_date_timezone');

        $validator
            ->scalar('schoolbox_config_external_type')
            ->maxLength('schoolbox_config_external_type', 4294967295)
            ->requirePresence('schoolbox_config_external_type', 'create')
            ->notEmptyString('schoolbox_config_external_type');

        $validator
            ->scalar('schoolbox_first_file_upload_year')
            ->maxLength('schoolbox_first_file_upload_year', 4294967295)
            ->requirePresence('schoolbox_first_file_upload_year', 'create')
            ->notEmptyFile('schoolbox_first_file_upload_year');

        return $validator;
    }
}
