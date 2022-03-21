<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        
        <div class="title">
            <h1>Adicionar propriedade</h1>
            <a class="btn" href="<?=BASE_URL?>admin/property">Voltar</a>
        </div>

        <div class="box-users">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/propertySubmit"
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
                        placeholder="Nome da propriedade..."
                    />
                </div>

                <div class="form-item">
                    <select name="type" title="type" id="type">
                        <option value="">Selecionar</option>
                        <option value="commertial">Comercial</option>
                        <option value="residential">Residencial</option>
                    </select>
                </div>

                <div class="form-item">
                    <label for="price">Preço</label>
                    <input
                        type="text"
                        name="price"
                        id="price"
                        placeholder="Preço do imóvel..."
                    />
                </div>

                <div class="form-item">
                    <label for="image" class="avatar">Selecionar imagem</label>
                    <input
                        type="file"
                        name="image"
                        id="image"
                    />
                </div>
    
                <input type="submit" class="btn" value="Adicionar"/>
            </form>

        </div>

    </section>

</section>