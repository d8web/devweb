<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        
        <div class="title">
            <h1>Adicionar cliente</h1>
        </div>

        <div class="box-users">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/newClientSubmit"
                method="POST"
                enctype="multipart/form-data"
                id="clients"
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
                        placeholder="Digite o nome..."
                    />
                </div>

                <div class="form-item">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Digite o email..."
                    />
                </div>

                <div class="form-item">
                    <label for="type">Tipo</label>
                    <select title="type" name="type" id="type">
                        <option value="fisica">Pessoa fisica</option>
                        <option value="juridica">Pessoa jurídica</option>
                    </select>
                </div>
    
                <div class="form-item" data-ref="cpf">
                    <label for="cpf">CPF</label>
                    <input
                        type="text"
                        name="cpf"
                        id="cpf"
                        placeholder="Digite o cpf..."
                    />
                </div>

                <div class="form-item" data-ref="cnpj" style="display: none;">
                    <label for="cpf">CNPJ</label>
                    <input
                        type="text"
                        name="cnpj"
                        id="cnpj"
                        placeholder="Digite o cnpj..."
                    />
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

<script src="https://unpkg.com/imask"></script>
<script>
    IMask(
        document.getElementById("cpf"),
        {mask: "000.000.000-00"}
    );
    IMask(
        document.getElementById("cnpj"),
        {mask: "00.000.000/0000-00"}
    )

    let select = document.getElementById("type")
    select.addEventListener("change", (e) => {
        if(e.target.value === "fisica") {
            document.querySelector("[data-ref=cpf]").style.display = "flex"
            document.querySelector("[data-ref=cnpj]").style.display = "none"
        } else {
            document.querySelector("[data-ref=cpf]").style.display = "none"
            document.querySelector("[data-ref=cnpj]").style.display = "flex"
        }
    })
</script>