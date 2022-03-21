<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        <h1>Configurações</h1>

        <div class="box-users">

            <form class="form" action="<?=BASE_URL?>admin/updateConfig" method="POST" enctype="multipart/form-data">

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
                        value="<?=$config->nameAuthor?>"
                        placeholder="Digite seu nome..."
                    />
                </div>
    
                <div class="form-item">
                    <label for="description">Descrição</label>
                    <textarea name="description" id="description" placeholder="Digite a descrição"><?=$config->description?></textarea>
                </div>

                <div class="img-about">
                    <img src="<?=BASE_URL?>assets/images/about/<?=$config->image?>" alt="about-image"/>
                </div>
    
                <div class="form-item">
                    <label for="imageConfig" class="avatar">Selecionar imagem</label>
                    <input
                        type="file"
                        name="imageConfig"
                        id="imageConfig"
                    />
                </div>
                
                <input type="hidden" name="oldImage" value="<?=$config->image?>"/>
                <input type="hidden" name="id" id="id" value="<?=$config->id?>"/>
    
                <input type="submit" class="btn" value="Salvar"/>
            </form>

        </div>

    </section>

</section>