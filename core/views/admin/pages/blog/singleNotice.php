<?php use core\helpers\Functions; ?>

<section class="content">

    <?=Functions::RenderAdmin([
        "partials/navbar"
    ], ["loggedAdmin" => $loggedAdmin]); ?>

    <section class="p-30 users pt-80">

        <div class="title">
            <h1>Editar - <?=$notice->title?> | <?=$notice->categoryName?></h1>
        </div>

        <div class="box-users">

            <div class="single-notice-box">
                <form
                    class="form mr-0"
                    action="<?= BASE_URL ?>admin/editPostSubmit"
                    method="POST"
                >
    
                    <?php if (!empty($flash)) : ?>
                        <div class="flash-message">
                            <?= $flash; ?>
                        </div>
                    <?php endif; ?>
    
                    <?php if (!empty($success)) : ?>
                        <div class="flash-success">
                            <?= $success; ?>
                        </div>
                    <?php endif; ?>
    
                    <div class="form-item">
                        <label for="title">Título</label>
                        <input
                            type="text"
                            name="title"
                            id="title"
                            placeholder="Digite o título do serviço..."
                            value="<?=$notice->title?>"
                        />
                    </div>
    
                    <div class="form-item">
                        <label for="body">Corpo</label>
                        <textarea
                            name="body"
                            id="body"
                            class="single-body-notice"
                            placeholder="Digite o corpo do depoimento..."><?=$notice->body?></textarea>
                    </div>

                    <input type="hidden" name="id" value="<?=$notice->id?>"/>
    
                    <input type="submit" class="btn" value="Salvar" />
                </form>
                
                <div class="right-single-notice">
                    
                    <span class="category-single-notice">
                        <strong>Categoria: </strong><?=$notice->categoryName?>
                    </span>

                    <div class="notice-single-thumb">
                        <img src="<?=BASE_URL?>assets/images/posts/<?=$notice->thumbnail?>" alt="thumbnail-notice"/>
                    </div>

                    <a
                        class="btn btn-full btn-del mb-20"
                        href="<?=BASE_URL?>admin/deletePost?id=<?=Functions::aesEncrypt($notice->id)?>&oldImage=<?=$notice->thumbnail?>"
                    >Deletar post</a>

                    <form
                        action="<?=BASE_URL?>admin/updateThumbandCategory"
                        method="post"
                        enctype="multipart/form-data"
                    >
                        <div class="form-single-notice-item">
                            <label for="category">Categoria</label>
                            <select title="category" name="category">
                                <?php foreach ($categories as $item) : ?>
                                    <option value="<?=$item->id?>" <?= ($notice->categoryName === $item->name) ? "selected" : ""?>>
                                        <?=$item->name?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-single-notice-item">
                            <label for="thumbnail" class="thumbnail">Escolher imagem</label>
                            <input type="file" name="thumbnail" id="thumbnail" />
                        </div>
                        
                        <input type="hidden" name="oldImage" value="<?=$notice->thumbnail?>"/>
                        <input type="hidden" name="id" value="<?=$notice->id?>"/>
                        <input class="btn btn-full mt-10" type="submit" value="Salvar"/>

                    </form>

                </div>

            </div>


        </div>

    </section>

</section>

<script src="https://cdn.tiny.cloud/1/bbckk8orf5zz7k60a6crudo1xwxu1sp0nbeoey6smjj4airx/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
    tinymce.init({
        selector: 'textarea',
        plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
        toolbar: 'bold italic checklist table',
        toolbar_mode: 'floating',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        menubar: false,
        entity_encode: "raw",
        content_style: 'body { font-family:"Ping Pong",Helvetica,Arial,sans-serif; font-size:18px }',
    });
</script>