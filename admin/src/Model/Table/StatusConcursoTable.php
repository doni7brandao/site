<?php

namespace App\Model\Table;


class StatusConcursoTable extends BaseTable
{
    public function initialize(array $config)
    {
        $this->table('status_concurso');
        $this->primaryKey('id');
        $this->entityClass('StatusConcurso');
    }
}
