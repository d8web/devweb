<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 pt-80">

        <div class="title">
            <h1>Slides</h1>
            <a class="btn btn-sm" href="<?=BASE_URL?>admin/newslide">Adicionar</a>
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

        <?php if(count($sliders) > 0): ?>
            <div class="wrapper-table-client-payments">
                <table class="table-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Url</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($sliders as $item): ?>
                            <tr>
                                <td><?=$item->id?></td>
                                <td><?=$item->url?></td>
                                <td>
                                    <div class="buttons-flex">
                                        <button
                                            onclick='handleOpenModal("<?= ($item->id) ?>")'
                                        >Editar</button>
                                        <a
                                            href="<?=BASE_URL?>admin/deleteSlide?id=<?=$item->id?>"
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
            <p class="text-dark">Nenhum slide cadastrado!</p>
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
            action="<?=BASE_URL?>admin/editslideSubmit"
            method="POST"
            enctype="multipart/form-data"
        >
            
            <div class="img-slide" id="img-slide">
                <img src="" alt=""/>
            </div>

            <div class="form-item">
                <label for="slide" class="avatar">Selecionar imagem</label>
                <input
                    type="file"
                    name="slide"
                    id="slide"
                />
            </div>

            <input type="hidden" id="oldImage" name="oldImage"/>
            <input type="hidden" id="id" name="id"/>

            <input type="submit" class="btn" value="Salvar"/>
        </form>

    </div>
</section>

<script>

    const handleOpenModal = async (id) => {
        document.querySelector(".modal").style.display = "flex"
        
        let result = await fetch("<?=BASE_URL?>admin/getSlidebyId", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({id})
        })

        let json = await result.json();
        if(!json.error) {

            document.getElementById("id").value = json.result.id
            document.querySelector(".img-slide img").src = "http://localhost/project/public/assets/images/sliders/" + json.result.url
            document.getElementById("oldImage").value = json.result.url

        }
    }

    let closeModal = () => {
        document.querySelector(".modal").style.display = "none"
    }

</script>