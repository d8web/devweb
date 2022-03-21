<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">

        <div class="title">
            <h1>Categorias</h1>
            <a class="btn btn-large" href="<?=BASE_URL?>admin/newCategory">Adicionar categoria</a>
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

        <?php if(count($categories) > 0): ?>
            <div class="wrapper-table-client-payments">
                <table class="table-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $item): ?>
                            <tr>
                                <td><?=$item->id?></td>
                                <td><?=$item->name?></td>
                                <td>
                                    <div class="buttons-flex">
                                        <button
                                            onclick='handleOpenModal("<?= ($item->id) ?>")'
                                        >Editar</button>
                                        <a
                                            href="<?=BASE_URL?>admin/deleteCategory?id=<?=$item->id?>"
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
            <p class="text-dark">Nenhuma categoria cadastrada!</p>
        <?php endif ?>

        <div class="notices-area">

            <div class="title">
                <h1>Posts</h1>
                <a class="btn btn-large" href="<?=BASE_URL?>admin/newPost">Adicionar post</a>
            </div>
            
            <div class="notices-container">
                <?php foreach($notices as $item): ?>
                    <div
                        style="background-image: linear-gradient(to bottom, rgba(0,0,0,.8), rgba(0,0,0,.9) 100%), url('<?=BASE_URL?>/assets/images/posts/<?=$item->thumbnail?>');"
                        class="notice-single-bg"
                    >
                        <a href="<?=BASE_URL?>admin/singleNotice?slug=<?=$item->slug?>">
                            <div class="notice-box">
                                <div class="notice-body">
                                    <h2>
                                        <?=strlen($item->title) > 60 ? substr($item->title, 0, 50)."..." : $item->title?>
                                    </h2>
                                    <p><?=strip_tags(substr($item->body, 0, 170))?>...</p>
                                    <div class="bottom-notice">
                                        <span><strong>Author: </strong> <?=$item->userName?></span>
                                        <span class="category-text"><?=$item->categoryName?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
            
        </div>

    </section>

</section>

<section class="modal">
    <div class="modal-content">
        
        <div class="close" onClick="closeModal()">
            <i class="fa fa-times"></i>
        </div>

        <form
            class="form mr-0"
            action="<?=BASE_URL?>admin/editcategorySubmit"
            method="POST"
            enctype="multipart/form-data"
        >

                <div class="form-item">
                    <label for="name">Nome da categoria</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Digite o nome da categoria..."
                    />
                </div>

            <input type="hidden" id="id" name="id"/>

            <input type="submit" class="btn" value="Salvar"/>
        </form>

    </div>
</section>

<script>

    const handleOpenModal = async (id) => {
        document.querySelector(".modal").style.display = "flex"
        
        let result = await fetch("<?=BASE_URL?>admin/getCategoryById", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({id})
        })

        let json = await result.json();
        if(!json.error) {

            document.getElementById("id").value = json.result.id
            document.getElementById("name").value = json.result.name

        }
    }

    let closeModal = () => {
        document.querySelector(".modal").style.display = "none"
    }

</script>