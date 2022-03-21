<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        
        <div class="title">
            <h1>Clientes</h1>
            <a class="btn btn-large" href="<?=BASE_URL?>admin/newClient">Adicionar cliente</a>
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

        <div class="search-container">
            <form action="<?=BASE_URL?>admin/searchClient" method="POST">
                <div class="form-item">
                    <label for="name">Pesquisar um cliente</label>
                    <input
                        type="search"
                        name="search"
                        id="search"
                        placeholder="Pesquisar clientes..."
                        value="<?=isset($searchTerm) && !empty($searchTerm) ? $searchTerm : ""?>"
                    />
                </div>

                <input class="btn" type="submit" value="Pesquisar"/>
            </form>
        </div>
        
        <?php if(isset($searchTerm) && !empty($searchTerm)): ?>
            <div class="founded">
                <?php if(count($clients) == 1): ?>
                    <h4>Foi encontrado <span><?=count($clients)?></span> resultado com o termo <span><?=$searchTerm?></span>.</h4>
                <?php elseif(count($clients) > 1): ?>
                    <h4>Foram encontrados <span><?=count($clients)?></span> resultados com o termo <span><?=$searchTerm?></span>.</h4>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="clients-container">

            <?php if(count($clients) > 0): ?>
                <?php foreach($clients as $item):?>
                    <div class="box-client">
                        <div class="image-client">
                            <img src="<?=BASE_URL?>admin/assets/images/clients/<?=$item->avatar?>" alt="client"/>
                        </div>
                        <div class="info-client">
                            <div class="flex-client-item">
                                <strong>Nome:</strong>
                                <span><?=$item->name?></span>
                            </div>
                            <div class="flex-client-item">
                                <strong>Email:</strong>
                                <span><?=$item->email?></span>
                            </div>
                            <div class="flex-client-item">
                                <strong>Tipo:</strong>
                                <span>
                                    <?=$item->type === "fisica" ? "Pessoa fisica" : "Pessoa jurídica"?>
                                </span>
                            </div>
                            <div class="flex-client-item">
                                <strong><?=$item->type === "fisica" ? "CPF" : "CNPJ"?></strong>
                                <span><?=$item->number?></span>
                            </div>
                        </div>
                        <div class="buttons-client-flex">
                            <a
                                class="btn-client-edit"
                                href="<?=BASE_URL?>admin/editClient?id=<?=Functions::aesEncrypt($item->id)?>"
                            >Editar</a>
                            <a
                                class="btn-client-del"
                                href="<?=BASE_URL?>admin/deleteClient?id=<?=Functions::aesEncrypt($item->id)?>"
                                onclick="return confirm('Deseja realmente excluir este usuário?')"
                            >Excluir</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else: ?>
                <p>Nenhum cliente para mostrar!</p>
            <?php endif ?>

        </div>

    </section>

</section>