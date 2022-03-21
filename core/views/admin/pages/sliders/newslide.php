<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        <h1>Adicionar slide</h1>

        <div class="box-users">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/newslideSubmit"
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
                    <label for="slide" class="avatar">Selecionar imagem</label>
                    <input
                        type="file"
                        name="slide"
                        id="slide"
                    />
                </div>
    
                <input type="submit" class="btn" value="Adicionar"/>
            </form>

        </div>

    </section>

</section>