<script type="text/javascript">
    var idPublicacao = <?=$id?>;
</script>
<?= $this->Html->script('controller/publicacoes.cadastro.js', ['block' => 'scriptBottom']) ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-content">
                        <?php
                            echo $this->Form->create($publicacao, [
                                "url" => [
                                    "controller" => "publicacao",
                                    "action" => "save",
                                    $id
                                ],
                                'enctype' => 'multipart/form-data',
                                "role" => "form"]);
                            ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_erro',
                                'type' => 'error',
                                'message' => 'Ocorreu um erro ao salvar a publicação',
                                'details' => ''
                            ]) ?>
                            <?=$this->element('message', [
                                'name' => 'cadastro_info',
                                'type' => 'info',
                                'restore' => true,
                                'message' => 'Foi detectado que existem informações não salvas dentro do cache de seu navegador. Clique em restaurar para recuperar esses dados e continuar com o cadastro ou clique em deecartar para excluir estes dados. Nenhuma das opções afetam em nada no banco de dados.'
                            ]) ?>
                            <?= $this->Flash->render() ?>
                            <?= $this->Form->hidden('enviaArquivo', ["id" => "enviaArquivo"]) ?>
                            <legend>Dados Cadastrais</legend>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("numero", "Número") ?>
                                        <?= $this->Form->text("numero", ["id" => "numero", "class" => "form-control", "maxlength" => 60]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("titulo", "Título") ?>
                                        <?= $this->Form->text("titulo", ["id" => "titulo", "class" => "form-control", "maxlength" => 100]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("data", "Data") ?>
                                        <?= $this->Form->text("data", ["id" => "data", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group label-control">
                                        <?= $this->Form->label("hora", "Hora") ?>
                                        <?= $this->Form->text("hora", ["id" => "hora", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <?= $this->Form->label("descricao", "Descrição") ?>
                                        <?= $this->Form->textarea("descricao", ["id" => "descricao", "class" => "form-control"]) ?>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php if($id > 0): ?>
                                    <div id="panel_arquivo">
                                        <div class="col-md-9">
                                            <div class="form-group form-file-upload is-fileinput">
                                                Arquivo atual: <?=$this->Html->link($publicacao->titulo, '/../' . $publicacao->arquivo, ['target' => '_blank'])?>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" onclick="toggleArquivo()" class="btn btn-default btn-simple btn-wd btn-lg">Substituir Arquivo</button>
                                        </div>
                                    </div>
                                    <div id="panel_envio" style="display: none">
                                        <div class="col-md-12">
                                            <div class="form-group form-file-upload is-fileinput">
                                                <?= $this->Form->label("arquivo", "Arquivo") ?>
                                                <?= $this->Form->file("arquivo", ["id" => "arquivo", "class" => "form-control"]) ?>
                                                <span class="material-input"></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-md-12">
                                        <div class="form-group form-file-upload is-fileinput">
                                            <?= $this->Form->label("arquivo", "Arquivo") ?>
                                            <?= $this->Form->file("arquivo", ["id" => "arquivo", "class" => "form-control"]) ?>
                                            <span class="material-input"></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Outras Opções</label> <br/>
                                        <div class="togglebutton">
                                            <label>
                                                <?= $this->Form->checkbox("ativo", ["id" => "ativo"]) ?> Ativo
                                            </label>
                                        </div>
                                        <span class="material-input"></span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" onclick="return validar()" class="btn btn-success pull-right">Salvar</button>
                            <?php if ($id > 0) :?>
                                <button type="button" onclick="window.location='<?= $this->Url->build(['action' => 'add']) ?>'" class="btn btn-warning pull-right">Novo</button>
                            <?php endif; ?>
                            <button type="reset" class="btn btn-default pull-right">Limpar</button>
                            <button type="button" onclick="window.location='<?= $this->Url->build('/publicacoes') ?>'" class="btn btn-info pull-right">Voltar</button>
                            <div class="clearfix"></div>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
