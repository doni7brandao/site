<?php

namespace App\Model\Table;


class MensagemTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('mensagem');
        $this->primaryKey('id');
        $this->entityClass('Mensagem');

        $this->belongsTo('Rementente', [
            'className' => 'Rementente',
            'foreignKey' => 'rementente',
            'propertyName' => 'rementente',
            'joinType' => 'LEFT OUTER'
        ]);
    }
}