<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        
        <div class="title">
            <h1>Usuários</h1>
            <a
                class="btn"
                href="<?=BASE_URL?>admin/newuser"
            >Adicionar</a>
        </div>

        <div class="box-users">

            <form class="form" action="<?=BASE_URL?>admin/updateUser" method="POST" enctype="multipart/form-data">

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
                        value="<?=$loggedAdmin->name?>"
                        placeholder="Digite seu nome..."
                    />
                </div>
    
                <div class="form-item">
                    <label for="password">Senha</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Digite sua senha..."
                    />
                </div>
    
                <div class="form-item">
                    <label for="password_confirm">Confirmar senha</label>
                    <input
                        type="password"
                        name="password_confirm"
                        id="password_confirm"
                        placeholder="Repita a senha..."
                    />
                </div>
    
                <div class="form-item">
                    <label for="avatar" class="avatar">Selecionar imagem</label>
                    <input
                        type="file"
                        name="avatar"
                        id="avatar"
                    />
                    <input type="hidden" name="oldImage" value="<?=$loggedAdmin->avatar?>"/>
                </div>
    
                <input type="submit" class="btn" value="Salvar"/>
            </form>

        </div>

    </section>

</section>