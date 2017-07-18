<script type="text/javascript">
    function validar() {
        if ($("#usuario").val() == "") {
            $("#erro").html("É obrigatório informar nome do usuário ou e-mail.");
            return false;
        }

        if ($("#senha").val() == "") {
            $("#erro").html("É obrigatório informar a senha de acesso ao sistema.");
            return false;
        }

        return true;
    }

</script>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3">
                <?php
                    echo $this->Form->create("usuario", [
                        'id' => 'form_login',
                        'url' => [
                            'controller' => 'system',
                            'action' => 'logon'
                        ]]);
                    ?>
                    <div class="card card-login card-hidden">
                        <div class="card-header text-center" data-background-color="green">
                            <h4 class="card-title">Painel de Controle</h4>
                            <p>Prefeitura Municipal de Coqueiral - Minas Gerais</p>
                        </div>
                        <p class="category text-center">
                        </p>
                        <center>
                            <?= $this->Flash->render() ?>
                             <span id="erro" class="text-danger"></span>
                        </center>
                        <div class="card-content">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock_outline</i>
                                </span>
                                <div class="form-group label-floating">
                                    <?= $this->Form->label('usuario', 'Nova Senha', ['class' => 'control-label']) ?>
                                    <?= $this->Form->text('usuario', ['id' => 'usuario', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">lock</i>
                                </span>
                                <div class="form-group label-floating">
                                    <?= $this->Form->label('senha', 'Confirme a Senha', ['class' => 'control-label']) ?>
                                    <?= $this->Form->password('senha', ['id' => 'senha', 'class' => 'form-control']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="footer text-center">
                            <button type="button" class="btn btn-danger btn-simple btn-wd btn-lg">Cancelar</button>
                            <button type="submit" class="btn btn-success btn-simple btn-wd btn-lg">Salvar</button>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>