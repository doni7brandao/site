<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Session;
use Cake\ORM\TableRegistry;
use \Exception;


class BannersController extends AppController
{

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        $t_banners = TableRegistry::get('Banner');
        $limite_paginacao = Configure::read('Pagination.limit');
        
        $this->paginate = [
            'limit' => $limite_paginacao,
            'order' => [
                'nome' => 'ASC'
            ]
        ];

        $banners = $this->paginate($t_banners);
        $qtd_total = $t_banners->find('all')->count();
        
        $this->set('title', 'Banners');
        $this->set('icon', 'slideshow');
        $this->set('banners', $banners);
        $this->set('qtd_total', $qtd_total);
        $this->set('limit_pagination', $limite_paginacao);
    }

    public function add()
    {
        $mensagem = '<b>Dica 1:</b> Caso necessite de um banner sem prazo de validade, basta apenas deixar o campo \'Validade\' em branco.<br/> ';
        $mensagem = $mensagem . '<b>Dica 2:</b> Não é preciso colocar endereço completo do link de destino, caso o destno esteja no mesmo site. <br/> ';
        $mensagem = $mensagem . '<b>Dica 3:</b> O formato do destino pode ser \'http://www.exemplo.com.br/pagina/item.html\' ou \'pagina/item.html\', por exemplo. <br/>';
        $mensagem = $mensagem . '<b>Dica 4:</b> Recomenda-se ativar a opção \'Abrir em nova janela\', quando o destino leva para o outro site. <br/>';
        $mensagem = $mensagem . '<b>Dica 5:</b> A imagem do banner deve ter obrigatoriamente, o tamanho de 1400 x 730.';
        
        $this->Flash->info($mensagem);
        $this->redirect(['action' => 'cadastro', 0]);
    }

    public function edit(int $id)
    {
        $this->redirect(['action' => 'cadastro', $id]);
    }

    public function cadastro(int $id)
    {
        $title = ($id > 0) ? 'Edição do Banner' : 'Novo Banner';
        $icon = 'slideshow';

        $t_banners = TableRegistry::get('Banner');

        if($id > 0)
        {
            $banner = $t_banners->get($id);
            $this->set('banner', $banner);
        }
        else
        {
            $this->set('banner', null);
        }

        $this->set('title', $title);
        $this->set('icon', $icon);
        $this->set('id', $id);
    }

    public function save(int $id)
    {
        if ($this->request->is('post')) 
        {
            $this->insert();
        } 
        elseif ($this->request->is('put')) 
        {
            $this->update($id);
        }
    }

    protected function insert()
    {
        try
        {
            $t_banners = TableRegistry::get('Banner');
            $entity = $t_banners->newEntity($this->request->data());

            $entity->validade = $this->Format->formatDateDB($entity->validade);

            $arquivo = $this->request->getData('arquivo');
            $entity->imagem = $this->salvarArquivo($arquivo);

            $t_banners->save($entity);
            $this->Flash->greatSuccess('Banner salvo com sucesso.');

            $propriedades = $entity->getOriginalValues();
            
            $auditoria = [
                'ocorrencia' => 33,
                'descricao' => 'O usuário publicou um novo banner para página inicial.',
                'dado_adicional' => json_encode(['id_novo_banner' => $entity->id, 'dados_banner' => $propriedades]),
                'usuario' => $this->request->session()->read('UsuarioID')
            ];

            $this->Auditoria->registrar($auditoria);

            if($this->request->session()->read('UsuarioSuspeito'))
            {
                $this->Monitoria->monitorar($auditoria);
            }

            $this->redirect(['action' => 'cadastro', $entity->id]);
        }
        catch(Exception $ex)
        {
            $this->Flash->exception('Ocorreu um erro no sistema ao salvar o banner', [
                'params' => [
                    'details' => $ex->getMessage()
                ]
            ]);

            $this->redirect(['action' => 'cadastro', 0]);
        }
    }

    private function removerArquivo($arquivo)
    {
        $diretorio = Configure::read('Files.paths.public');
        $arquivo = $diretorio . $arquivo;

        $file = new File($arquivo);

        if($file->exists())
        {
            $file->delete();
        }
    }

    private function salvarArquivo($arquivo)
    {
        $diretorio = Configure::read('Files.paths.bannerHome');
        $url_relativa = Configure::read('Files.urls.bannerHome');

        $file_temp = $arquivo['tmp_name'];
        $nome_arquivo = $arquivo['name'];

        $file = new File($file_temp);
        $pivot = new File($nome_arquivo);

        $novo_nome = uniqid() . '.' . $pivot->ext();

        if(!$this->File->validationExtension($pivot, $this->File::TYPE_FILE_IMAGE))
        {
            throw new Exception("A extensão do arquivo é inválida.");
        }
        elseif(!$this->File->validationSize($file))
        {
            $maximo = $this->File->getMaxLengh($this->File::TYPE_FILE_IMAGE);
            $divisor = Configure::read('Files.misc.megabyte');

            $maximo = round($maximo / $divisor, 0);

            $mensagem = "O tamaho da imagem enviada é muito grande. O tamanho máximo do arquivo de imagens é de $maximo MB.";
            
            throw new Exception($mensagem);
        }
        
        list($largura, $altura) = getimagesize($file_temp);

        if($largura != 1400 || $altura != 730)
        {
            throw new Exception("As dimensões da imagem devem ser obrigatoriamente 1400 x 730.");
        }
        
        $file->copy($diretorio . $novo_nome, true);

        return $url_relativa . $novo_nome;
    }
}