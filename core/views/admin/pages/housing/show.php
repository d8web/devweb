<?php

use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], ["loggedAdmin" => $loggedAdmin]); ?>

    <section class="p-30 users pt-80">

        <div class="title">
            <h1>Imóvel</h1>
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

        <div class="housing-flex">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/updateHousingSubmit"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="form-item">
                    <label for="name">Nome</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do imóvel..."
                        value="<?=$list["housing"]->name?>"
                    />
                </div>
                <div class="form-item">
                    <label for="area">Área</label>
                    <input
                        type="number"
                        name="area"
                        id="area"
                        placeholder="Área do imóvel..."
                        value="<?=$list["housing"]->area?>"
                    />
                </div>
                <div class="form-item">
                    <label for="price">Preço</label>
                    <input
                        type="text"
                        name="price"
                        id="price"
                        placeholder="Preço do imóvel..."
                        value="<?=$list["housing"]->price?>"
                    />
                </div>

                <input
                    type="hidden"
                    name="id"
                    value="<?=Functions::aesEncrypt($list["housing"]->id)?>"
                />
                <input
                    type="hidden"
                    name="propertyId"
                    value="<?=Functions::aesEncrypt($list["housing"]->propertyId)?>"
                />
                <input type="submit" class="btn" value="Salvar" />
            </form>

            <div class="images-housing">

                <div class="title">
                    <h1>Adicionar imagens</h1>
                </div>

                <div class="images-list-container">
                    <?php foreach($list["images"] as $item): ?>
                        <div class="image-box-housing">
                            <img
                                src="<?=BASE_URL?>assets/images/housings/<?=$item->image?>"
                                alt="image-imóvel"
                            />
                            <a
                                href="<?=BASE_URL?>admin/delHousingImage?image=<?=$item->image?>&id=<?=Functions::aesEncrypt($list["housing"]->id)?>"
                            >Excluir</a>
                        </div>
                    <?php endforeach ?>
                </div>
                
                <form
                    action="<?=BASE_URL?>admin/newImagesHousing"
                    class="mt-10"
                    enctype="multipart/form-data"
                    method="POST"
                >
                    <div class="form-item">
                        <label for="image" class="avatar">Adicionar imagens</label>
                        <input type="file" name="image[]" id="image" multiple />
                    </div>
                    <input
                        type="hidden"
                        name="housingId"
                        value="<?=Functions::aesEncrypt($list["housing"]->id)?>"
                    />
                    <input type="submit" class="btn" value="Adicionar"/>
                </form>

            </div>

        </div>

    </section>

</section>