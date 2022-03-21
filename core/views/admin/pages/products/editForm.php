<?php

use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], ["loggedAdmin" => $loggedAdmin]); ?>

    <section class="p-30 users pt-80">

        <div class="title flex-between">
            <h1>Editar produto</h1>
            <a class="btn" href="<?=BASE_URL?>admin/products">Voltar</a>
        </div>

        <?php if (!empty($flash)) : ?>
            <div class="flash-message">
                <?= $flash; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)) : ?>
            <div class="flash-success">
                <?= $success; ?>
            </div>
        <?php endif; ?>


        <div class="content-edit">

            <form class="form mr-0 form-edit-product" action="<?= BASE_URL ?>admin/editProductSubmit" method="POST" enctype="multipart/form-data">

                <div class="form-item">
                    <label for="name">Nome</label>
                    <input type="text" name="name" id="name" placeholder="Nome do produto..." value="<?= $product->name ?>" />
                </div>

                <div class="form-item">
                    <label for="description">Descrição</label>
                    <textarea name="description" id="description" placeholder="Descrição do produto..." onkeypress="autoResize(this)" onkeyup="autoResize(this)" style="overflow: hidden;" onclick="autoResize(this)"><?= $product->description ?></textarea>
                </div>

                <div class="flex-property">
                    <div class="form-col-6">
                        <div class="form-item">
                            <label for="price">Preço</label>
                            <input type="text" name="price" id="price" placeholder="Preço do produto..." value="<?= $product->price ?>" />
                        </div>
                    </div>
                    <div class="form-col-6">
                        <div class="form-item">
                            <label for="width">Largura</label>
                            <input type="number" name="width" id="width" placeholder="Largura do produto..." value="<?= $product->width ?>" />
                        </div>
                    </div>
                    <div class="form-col-6">
                        <div class="form-item">
                            <label for="stock">Estoque</label>
                            <input type="number" name="stock" id="stock" placeholder="Quantidade em estoque..." value="<?= $product->stock ?>" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-col-6">
                        <div class="form-item">
                            <label for="height">Altura</label>
                            <input type="number" name="height" id="height" placeholder="Altura do produto..." value="<?= $product->height ?>" />
                        </div>
                    </div>
                    <div class="form-col-6">
                        <div class="form-item">
                            <label for="length">Comprimento</label>
                            <input type="number" name="length" id="length" placeholder="Comprimento do produto..." value="<?= $product->length ?>" />
                        </div>
                    </div>
                    <div class="form-col-6">
                        <div class="form-item">
                            <label for="weight">Peso</label>
                            <input type="text" name="weight" id="weight" placeholder="Peso do produto..." value="<?= $product->weight ?>" />
                        </div>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?= Functions::aesEncrypt($product->id) ?>" />
                <input type="submit" class="btn mt-responsive" value="Salvar" />
            </form>

            <div class="images-products">
                <div class="images-product-container">
                    <?php if (count($images) > 0) : ?>
                        <?php foreach ($images as $item) : ?>
                            <div class="box-image-single">
                                <div class="image-product">
                                    <img
                                        src="<?= BASE_URL ?>assets/images/products/<?= $item->url ?>"
                                        alt="image-product"
                                    />
                                </div>
                                <a
                                    href="<?=BASE_URL?>admin/imageDelete?image=<?=$item->url?>&productId=<?=Functions::aesEncrypt($product->id)?>"
                                >Excluir</a>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <p>Este produto não tem imagens!</p>
                    <?php endif; ?>
                </div>

                <form action="<?= BASE_URL ?>admin/addImagesProduct" enctype="multipart/form-data" method="POST" class="mt-20-images">

                    <div class="form-item mb-0">
                        <label for="image" class="avatar mb-0 w-100">Adicionar imagens</label>
                        <input type="file" name="image[]" id="image" multiple />
                    </div>

                    <input type="hidden" name="productId" value="<?= Functions::aesEncrypt($product->id) ?>" />
                    <input type="submit" class="btn mt-responsive mt-10" value="Adicionar" />
                </form>

            </div>

        </div>

    </section>

</section>

<script>
    const autoResize = (element) => {
        element.style.height = "5px"
        element.style.height = (element.scrollHeight) + "px"
    }
</script>