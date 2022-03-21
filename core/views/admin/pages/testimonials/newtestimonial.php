<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        <h1>Adicionar depoimento</h1>

        <div class="box-users">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/newtestimonialSubmit"
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
                    <label for="author">Author</label>
                    <input
                        type="text"
                        name="author"
                        id="author"
                        placeholder="Digite o nome do author..."
                    />
                </div>

                <div class="form-item">
                    <label for="body">Corpo</label>
                    <textarea name="body" id="body" cols="10" rows="10" placeholder="Digite o corpo do depoimento..."></textarea>
                </div>
    
                <input type="submit" class="btn" value="Adicionar"/>
            </form>

        </div>

    </section>

</section>