<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        
        <div class="title">
            <h1>Adicionar categoria</h1>
        </div>

        <div class="box-users">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/newCategorySubmit"
                method="POST"
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
                    <label for="name">Nome da categoria</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Digite o nome da categoria..."
                    />
                </div>
    
                <input type="submit" class="btn" value="Adicionar"/>
            </form>

        </div>

    </section>

</section>