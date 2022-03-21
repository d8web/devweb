<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        
        <div class="title">
            <h1>Editar propriedade</h1>
            <a class="btn" href="<?=BASE_URL?>admin/property">Voltar</a>
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

        <div class="box-property">

            <div class="left-property">
                <div class="box-info-property">Imagem</div>
                <img src="<?=BASE_URL?>assets/images/properties/<?=$property->image?>" alt="<?=$property->name?>"/>
            </div>

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/editPropertySubmit"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="box-info-property">Infomações</div>

                <div class="form-item">
                    <label for="name">Nome</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome da propriedade..."
                        value="<?=$property->name?>"
                    />
                </div>

                <div class="form-item">
                    <select name="type" title="type" id="type">
                        <option value="">Selecionar</option>
                        <option
                            value="commertial"
                            <?=$property->type == "commertial" ? "selected" : ""?>
                        >Comercial</option>
                        <option
                            value="residential"
                            <?=$property->type == "residential" ? "selected" : ""?>
                        >Residencial</option>
                    </select>
                </div>

                <div class="form-item">
                    <label for="price">Preço</label>
                    <input
                        type="text"
                        name="price"
                        id="price"
                        placeholder="Preço do imóvel..."
                        value="<?=$property->price?>"
                    />
                </div>
                
                <input type="hidden" name="id" value="<?=Functions::aesEncrypt($property->id)?>"/>
                <input type="hidden" name="oldImage" value="<?=$property->image?>"/>

                <div class="row align-center">
                    <div class="form-flex">
                        <div class="form-item">
                            <label for="image" class="avatar">Selecionar imagem</label>
                            <input
                                type="file"
                                name="image"
                                id="image"
                            />
                        </div>
                    </div>
                    <div class="form-flex">
                        <input type="submit" class="btn" value="Salvar"/>
                    </div>
                </div>    
                
            </form>

        </div>

        <div class="title">
            <h1>Adicionar imóvel</h1>
        </div>

        <div class="box-users">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/newHousingSubmit"
                method="POST"
                enctype="multipart/form-data"
            >
            
                <div class="row">
                    <div class="form-col-6">
                        <div class="form-item">
                            <label for="name">Nome</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                placeholder="Nome do imóvel..."
                            />
                        </div>
                    </div>
                    <div class="form-col-6">
                        <div class="form-item">
                            <label for="area">Área</label>
                            <input
                                type="number"
                                name="area"
                                id="area"
                                placeholder="Área do imóvel..."
                            />
                        </div>
                    </div>
                    <div class="form-col-6">
                        <div class="form-item">
                            <label for="price">Preço</label>
                            <input
                                type="text"
                                name="price"
                                id="price"
                                placeholder="Preço do imóvel..."
                            />
                        </div>
                    </div>
                </div>

                <div class="form-item">
                    <label for="imovel_image" class="avatar">Selecionar imagens</label>
                    <input
                        type="file"
                        name="imovel_image[]"
                        id="imovel_image"
                        multiple
                    />
                </div>
                
                <input type="hidden" name="idProperty" value="<?=Functions::aesEncrypt($property->id)?>"/>
                <input type="submit" class="btn" value="Adicionar"/>
            </form>

        </div>

        <div class="housing-container">

            <div class="title">
                <h1>Imóveis</h1>
            </div>

            <?php if(count($housings) > 0): ?>
            <div class="table-wrapper-housing">
                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Área</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($housings as $housing): ?>
                            <tr>
                                <td><?=$housing->name?></td>
                                <td>R$ <?=number_format($housing->price, 2, ",", ".")?></td>
                                <td><?=$housing->area?></td>
                                <td class="text-end">
                                    <a
                                        class="bg-button"
                                        href="<?=BASE_URL?>admin/showHousing?id=<?=Functions::aesEncrypt($housing->id)?>"
                                    >Ver</a>
                                    <a
                                        class="bg-red"
                                        onclick="return confirm('Deseja mesmo exluir esse imóvel junto com suas imagens?')"
                                        href="<?=BASE_URL?>admin/deleteHousing?id=<?=Functions::aesEncrypt($housing->id)?>&property=<?=Functions::aesEncrypt($property->id)?>"
                                    >Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <p>Esta propriedade não possui nenhum imóvel cadastrado!</p>
            <?php endif ?>

        </div>

    </section>

</section>