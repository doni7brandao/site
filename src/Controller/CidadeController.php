<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class CidadeController extends AppController
{
    public function historico()
    {
       $socialTags = [
           'og:locale' => 'pt_BR',
           'og:type' => 'article',
           'article:publisher' => 'https://www.facebook.com/prefeituradecoqueiral',
           'og:title' => 'História de Coqueiral | Prefeitura Municipal de Coqueiral',
           'og:description' => 'A história da cidade de Coqueiral - MG.',
           'og:url' => 'http://coqueiral.mg.gov.br/cidade/historico',
           'og:site_name' => 'Prefeitura Municipal de Coqueiral',
           'og:image' => 'img/slide/slider_historico1.jpg',
           'og:image:width' => '600',
           'og:image:height' => '400'
       ];
       
       $this->set('title', "História de Coqueiral");
       $this->set('socialTags', $socialTags);
    }

    public function perfil()
    {
        $this->set('title', "O Perfil do Município");
    }

    public function localizacao()
    {
        $this->set('title', "Localização da Cidade");
    }
}