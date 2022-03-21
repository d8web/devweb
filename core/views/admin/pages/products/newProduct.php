<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">

        <div class="title">
            <h1>Adicionar produto</h1>
            <a class="btn" href="<?=BASE_URL?>admin/products">Voltar</a>
        </div>

        <div class="box-users">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/newProductSubmit"
                method="POST"
                enctype="multipart/form-data"
            >

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
    
                <div class="form-item">
                    <label for="name">Nome</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Digite o nome do produto..."
                    />
                </div>

                <div class="form-item">
                    <label for="description">Descrição</label>
                    <textarea
                        name="description"
                        id="description"
                        placeholder="Digite a descrição do produto..."></textarea>
                </div>

                <div class="form-item">
                    <label for="price">Preço</label>
                    <input
                        type="text"
                        name="price"
                        id="price"
                        placeholder="Digite o preço do produto..."
                    />
                </div>

                <div class="form-item">
                    <label for="width">Largura</label>
                    <input
                        type="number"
                        name="width"
                        id="width"
                        placeholder="Digite a largura do produto..."
                    />
                </div>

                <div class="form-item">
                    <label for="height">Altura</label>
                    <input
                        type="number"
                        name="height"
                        id="height"
                        placeholder="Digite a altura do produto..."
                    />
                </div>

                <div class="form-item">
                    <label for="length">Comprimento</label>
                    <input
                        type="number"
                        name="length"
                        id="length"
                        placeholder="Digite o comprimento do produto..."
                    />
                </div>

                <div class="form-item">
                    <label for="weight">Peso</label>
                    <input
                        type="text"
                        name="weight"
                        id="weight"
                        placeholder="Digite o peso do produto..."
                    />
                </div>

                <div class="form-item">
                    <label for="stock">Estoque</label>
                    <input
                        type="number"
                        name="stock"
                        id="stock"
                        placeholder="Digite a quantidade do estoque do produto..."
                    />
                </div>

                <div class="form-item">
                    <label for="image" class="avatar">Selecionar imagens</label>
                    <input
                        type="file"
                        name="image[]"
                        id="image"
                        multiple
                    />
                </div>
    
                <input type="submit" class="btn" value="Adicionar"/>
            </form>

        </div>

    </section>

</section>