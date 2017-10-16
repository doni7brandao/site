<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{   

    public function home()
    {
        $t_noticia = TableRegistry::get('Noticia');
        $t_licitacoes = TableRegistry::get('Licitacao');
        $t_banners = TableRegistry::get('Banner');
        
        $noticias = $t_noticia->find('all', [
            'contain' => ['Post' => ['Usuario' => ['Pessoa']]],
            'conditions' => [
                'Post.destaque' => true,
                'Post.ativo' => true
            ],
            'order' => ['Post.datapostagem' => 'DESC'], 
            'limit' => 3
        ]);

        $licitacoes = $t_licitacoes->find('all', [
            'conditions' => ['Licitacao.ativo' => true],
            'order' => ['Licitacao.id' => 'DESC'],
            'limit' => 5
        ]);

        $banners = $t_banners->find('all', [
            'conditions' => [
                'Banner.ativo' => true,
                'OR' =>[
                    'Banner.validade >=' => date('Y-m-d'),
                    'Banner.validade IS' => null,
                ]
            ],
            'order' => [
                'Banner.ordem' => 'ASC',
                'Banner.validade' => 'DESC',
            ]
        ]);

         $this->set('noticias', $noticias);
         $this->set('licitacoes', $licitacoes);
         $this->set('banners', $banners->toArray());
    }

    public function contato()
    {
        if($this->request->is('post'))
        {
            $nome = $this->request->getData('nome');
            $email = $this->request->getData('email');
            $endereco = $this->request->getData('endereco');
            $telefone = $this->request->getData('telefone');
            $assunto = $this->request->getData('assunto');
            $mensagem = $this->request->getData('mensagem');

            $this->registrarOuvidoria($nome, $email, $endereco, $telefone, $assunto, $mensagem);
        }
    }

    public function privacidade() { }
    public function contatosucesso() { }
    
    private function registrarOuvidoria($nome, $email, $endereco, $telefone, $assunto, $mensagem)
    {
        $idManifestante = $this->Ouvidoria->cadastrarManifestante($nome, $email, $endereco, $telefone);
        $idManifestacao = $this->Ouvidoria->inserirManifestacao($idManifestante, $assunto, $mensagem);

        $this->Ouvidoria->registrarHistorico($idManifestacao, 'Nova manifestação de ouvidoria', true);

        
    }

    
}
