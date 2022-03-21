<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        <h1>Adicionar usuário</h1>

        <div class="box-users">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/newuserSubmit"
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
                        placeholder="Digite seu nome..."
                    />
                </div>

                <div class="form-item">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Digite seu email..."
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
                        placeholder="Digite sua senha novamente..."
                    />
                </div>

                <div class="form-item">
                    <label for="admin">Adminstrador</label>
                    <select title="admin" name="admin">
                        <?php foreach(PERMISSIONS as $key => $item): ?>
                            <?php if($item !== $permission): ?>
                                <option value="<?=$key?>"><?=$item?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
    
                <div class="form-item">
                    <label for="avatar" class="avatar">Selecionar imagem</label>
                    <input
                        type="file"
                        name="avatar"
                        id="avatar"
                    />
                </div>
    
                <input type="submit" class="btn" value="Adicionar"/>
            </form>

        </div>

    </section>

</section>