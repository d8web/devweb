<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 pt-80">

        <div class="title">
            <h1>Testemunhas</h1>
            <a class="btn btn-sm" href="<?=BASE_URL?>admin/newtestimonial">Adicionar</a>
        </div>

        <?php if(!empty($flash)):?>
            <div class="flash-message mt-20-default">
                <?=$flash;?>
            </div>
        <?php endif; ?>

        <?php if(!empty($success)):?>
            <div class="flash-success mt-20-default">
                <?=$success;?>
            </div>
        <?php endif; ?>

        <?php if(count($testimonials) > 0): ?>
            <div class="wrapper-table-client-payments">
                <table class="table-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Author</th>
                            <th>Corpo</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($testimonials as $item): ?>
                            <tr>
                                <td><?=$item->id?></td>
                                <td><?=$item->author?></td>
                                <td class="w-200"><?=substr($item->body, 0, 50)?>...</td>
                                <td>
                                    <div class="buttons-flex">
                                        <button
                                            onclick='handleOpenModal("<?= ($item->id) ?>")'
                                        >Editar</button>
                                        <a
                                            href="<?=BASE_URL?>admin/deleteTestimonial?id=<?=$item->id?>"
                                            onClick="return confirm('Tem certeza que deseja excluir?')"
                                        >Deletar</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-dark">Nenhum depoimento cadastrado!</p>
        <?php endif ?>

    </section>

</section>

<section class="modal">
    <div class="modal-content">
        
        <div class="close" onClick="closeModal()">
            <i class="fa fa-times"></i>
        </div>

        <form
            class="form mr-0"
            action="<?=BASE_URL?>admin/edittimonialSubmit"
            method="POST"
            enctype="multipart/form-data"
        >
            <div class="form-item">
                <label for="author">Author</label>
                <input
                    type="text"
                    name="author"
                    id="author-modal"
                    placeholder="Digite o nome do author..."
                />
            </div>

            <div class="form-item">
                <label for="body">Corpo</label>
                <textarea
                    name="body"
                    id="body-modal"
                    placeholder="Digite o corpo do depoimento..."></textarea>
            </div>

            <input type="hidden" id="id" name="id"/>

            <input type="submit" class="btn" value="Salvar"/>
        </form>

    </div>
</section>

<script>

    const handleOpenModal = async (id) => {
        document.querySelector(".modal").style.display = "flex"
        
        let result = await fetch("<?=BASE_URL?>admin/getTestimonialById", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({id})
        })

        let json = await result.json();
        if(!json.error) {

            document.getElementById("id").value = json.result.id
            document.getElementById("author-modal").value = json.result.author
            document.getElementById("body-modal").value = json.result.body

        }
    }

    let closeModal = () => {
        document.querySelector(".modal").style.display = "none"
    }

</script>