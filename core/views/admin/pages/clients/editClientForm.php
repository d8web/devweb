<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">

        <div class="title flex-between">
            <h1>Editar cliente</h1>
            <a class="btn" href="<?=BASE_URL?>admin/clients">Voltar</a>
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

        <div class="grid-edit-clients">

            <div class="box-client-edit-grid">

                <div class="box-title-single">
                    <h3>Pagamentos pendentes do cliente</h1>
                </div>
                
                <?php if(count($paymentsPendingClient) > 0): ?>
                    <div class="wrapper-table-client-payments">
                        <table>
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
                                            <a href="" class="btn-client-edit">Enviar</a>
                                        </td>
                                        <td class="w-100">
                                            <a href="<?=BASE_URL?>admin/alterStatusPaid?id=<?=Functions::aesEncrypt($item->id)?>&clientId=<?=Functions::aesEncrypt($item->clientId)?>" class="btn-client-green">Marcar</a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-dark">Este cliente não possui pagamentos pendentes!</p>
                <?php endif ?>

            </div>

            <div class="box-client-edit-grid">

                <div class="box-title-single">
                    <h3>Pagamentos concluídos do cliente</h1>
                </div>
                    
                <?php if(count($paymentsConcludedClient) > 0): ?>
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
                                <?php foreach($paymentsConcludedClient as $item): ?>
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
                    <p class="text-dark">Este cliente não possui pagamentos concluídos!</p>
                <?php endif ?>

            </div>

            <div class="box-client-edit-grid">
                
                <div class="box-title-single">
                    <h3>Dados do cliente</h1>
                </div>

                <form
                    class="form mr-0"
                    action="<?=BASE_URL?>admin/editClientSubmit"
                    method="POST"
                    enctype="multipart/form-data"
                    id="clients"
                >

                    <div class="form-item">
                        <label for="name">Nome</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            placeholder="Digite o nome..."
                            value="<?=$client->name?>"
                        />
                    </div>

                    <div class="form-item">
                        <label for="email">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Digite o email..."
                            value="<?=$client->email?>"
                        />
                    </div>

                    <div class="form-item">
                        <label for="type">Tipo</label>
                        <select title="type" name="type" id="type">
                            <option
                                value="fisica"
                                <?=$client->type == "fisica" ? "selected" : ""?>
                            >Pessoa fisica</option>
                            <option
                                value="juridica"
                                <?=$client->type == "juridica" ? "selected" : ""?>
                            >Pessoa jurídica</option>
                        </select>
                    </div>
        
                    <div class="form-item" data-ref="cpf">
                        <label for="cpf">CPF</label>
                        <input
                            type="text"
                            name="cpf"
                            id="cpf"
                            placeholder="Digite o cpf..."
                            value="<?=$client->type == "fisica" ? $client->number : ""?>"
                        />
                    </div>

                    <div class="form-item" data-ref="cnpj" style="display: none;">
                        <label for="cpf">CNPJ</label>
                        <input
                            type="text"
                            name="cnpj"
                            id="cnpj"
                            placeholder="Digite o cnpj..."
                            value="<?=$client->type == "juridica" ? $client->number : ""?>"
                        />
                    </div>
        
                    <div class="form-item">
                        <label for="avatar" class="avatar">Selecionar imagem</label>
                        <input
                            type="file"
                            name="avatar"
                            id="avatar"
                        />
                    </div>
                    
                    <input type="hidden" name="oldImage" value="<?=$client->avatar?>"/>
                    <input type="hidden" name="id" id="id" value="<?=Functions::aesEncrypt($client->id)?>"/>

                    <input type="submit" class="btn" value="Salvar"/>
                </form>
            </div>

            <div class="box-client-edit-grid">
                
                <div class="box-title-single">
                    <h3>Adicionar pagamento</h1>
                </div>

                <form
                    class="form mr-0"
                    action="<?=BASE_URL?>admin/addPaymentClientSubmit"
                    method="POST"
                    id="payment"
                >

                    <div class="form-item">
                        <label for="namePayment">Nome do pagamento</label>
                        <input
                            type="text"
                            name="namePayment"
                            id="namePayment"
                            placeholder="Digite o nome do pagamento..."
                        />
                    </div>
        
                    <div class="form-item">
                        <label for="paymentValue">Valor do pagamento</label>
                        <input
                            type="text"
                            name="paymentValue"
                            id="paymentValue"
                            placeholder="Digite o valor do pagamento..."
                        />
                    </div>

                    <div class="form-item">
                        <label for="numberPlots">Número de parcelas</label>
                        <input
                            type="text"
                            name="numberPlots"
                            id="numberPlots"
                            placeholder="Digite o número de parcelas..."
                        />
                    </div>

                    <div class="form-item">
                        <label for="interval">Intervalo</label>
                        <input
                            type="text"
                            name="interval"
                            id="interval"
                            placeholder="Digite o intervalo..."
                        />
                    </div>

                    <div class="form-item">
                        <label for="expired">Vencimento</label>
                        <input
                            type="text"
                            name="expired"
                            id="expired"
                            placeholder="Digite a data de vencimento..."
                        />
                    </div>
                    
                    <input type="hidden" name="id" id="id" value="<?=Functions::aesEncrypt($client->id)?>"/>

                    <input type="submit" class="btn" value="Adicionar"/>
                </form>
            </div>

        </div>

    </section>

</section>

<script src="https://unpkg.com/imask"></script>
<script>

    IMask(
        document.getElementById("cpf"),
        { mask: "000.000.000-00" }
    );

    IMask(
        document.getElementById("cnpj"),
        { mask: "00.000.000/0000-00" }
    );

    IMask(
        document.getElementById("expired"),
        { mask: "00/00/0000" }
    );

    IMask(
        document.getElementById("numberPlots"),
        { mask: "00" }
    );

    IMask(
        document.getElementById("interval"),
        { mask: "00" }
    );

    let select = document.getElementById("type")
    select.addEventListener("change", (e) => {
        if(e.target.value === "fisica") {
            document.querySelector("[data-ref=cpf]").style.display = "flex"
            document.querySelector("[data-ref=cnpj]").style.display = "none"
        } else {
            document.querySelector("[data-ref=cpf]").style.display = "none"
            document.querySelector("[data-ref=cnpj]").style.display = "flex"
        }
    })

    if(document.getElementById("type").value == "fisica") {
        document.querySelector("[data-ref=cpf]").style.display = "flex"
        document.querySelector("[data-ref=cnpj]").style.display = "none"
    } else {
        document.querySelector("[data-ref=cpf]").style.display = "none"
        document.querySelector("[data-ref=cnpj]").style.display = "flex"
    }

    let input = document.getElementById("paymentValue");
    input.addEventListener("keypress", (e) => {

        let keyCode = (e.keyCode ? e.keyCode : e.which);

        // Permitir apenas que o usuário digite números
        if (keyCode > 47 && keyCode < 58) {
            formatNumber(input);
        } else {
            e.preventDefault();
        }

    })

    const formatNumber = (input) => {

        let item = input.value;

        item = item + "";
        item = parseInt(item.replace(/[\D]+/g, ''));
        item = item + '';
        item = item.replace(/([0-9]{2})$/g, ",$1");

        if(item.length > 6) {
            item = item.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
        }

        input.value = item;
        if(item == 'NaN') input.value = "";
    }

</script>