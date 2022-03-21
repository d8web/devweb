<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        
        <div class="title">
            <h1>Financeiro</h1>
            <!-- <a class="btn" href="">Adicionar categoria</a> -->
        </div>

        <?php if(!empty($flash)):?>
            <div class="flash-message">
                <?=$flash;?>
            </div>
        <?php endif; ?>

        <?php if(!empty($success)):?>
            <div class="flash-success">
                <?=$success;?>
            </div>
        <?php endif; ?>

        <div class="box-title-single">
            <h3>Pagamentos pendentes</h1>
            <a
                class="btn btn-sm btn-client-red"
                href="<?=BASE_URL?>admin/pdf?payment=pending"
                target="_blank"
            >Gerar pdf</a>
        </div>

        <?php if(count($paymentsPendingClient) > 0): ?>
            <div class="wrapper-table-client-payments">
                <table class="table-full">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th>Vencimento</th>
                            <th>E-mail</th>
                            <th class="text-end">Alterar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($paymentsPendingClient as $item): ?>
                            <tr
                                class="<?=(strtotime(date("Y-m-d")) >= strtotime($item->expired)) ? 'expired-table' : '' ?>"
                            >
                                <td><?=$item->name?></td>
                                <td><?=$item->clientName?></td>
                                <td><?=$item->value?></td>
                                <td><?=date("d/m/Y", strtotime($item->expired))?></td>
                                <td>
                                    <a
                                        href="<?=BASE_URL?>admin/sendEmailPaymentPending?email=<?=Functions::aesEncrypt($item->clientId)?>&portion=<?=Functions::aesEncrypt($item->id)?>"
                                        class="btn-client-edit"
                                    >Enviar</a>
                                </td>
                                <td class="w-100">
                                    <a href="<?=BASE_URL?>admin/alterStatus?id=<?=Functions::aesEncrypt($item->id)?>" class="btn-client-green">Marcar</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-dark">Não existem pagamentos pendentes!</p>
        <?php endif ?>

        <div class="box-title-single margin-top-table">
            <h3>Pagamentos concluídos</h1>
            <a
                class="btn btn-sm btn-client-red"
                href="<?=BASE_URL?>admin/pdf?payment=concluded"
                target="_blank"
            >Gerar pdf</a>
        </div>

        <?php if(count($paymentsPaidClient) > 0): ?>
            <div class="wrapper-table-client-payments">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Cliente</th>
                            <th>Valor</th>
                            <th class="text-end">Vencimento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($paymentsPaidClient as $item): ?>
                            <tr>
                                <td><?=$item->name?></td>
                                <td><?=$item->clientName?></td>
                                <td><?=$item->value?></td>
                                <td class="text-end">
                                    <?=date("d/m/Y", strtotime($item->expired))?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-dark">Não existem pagamentos com o status pago!</p>
        <?php endif ?>

    </section>

</section>