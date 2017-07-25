<h4 class="card-title">Log de Acesso ao Sistema</h4>
<table class="table">
    <thead class="text-primary">
        <tr>
            <th>IP</th>
            <th>Data de Acesso</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($log as $item): ?>
            <tr>
                <td><?= $item->ip ?></td>
                <td><?= date_format($item->data, 'd/m/Y H:i:s') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
<div class="material-datatables">
    <div class="row">
        <div class="col-sm-5">
            <div class="dataTables_paginate paging_full_numbers text-left" id="datatables_info"><?= $qtd_total ?> itens</div>
        </div>
    </div>
</div>
</div>

    