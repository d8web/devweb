<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">

        <div class="title">
            <h1>Adicionar post</h1>
        </div>

        <div class="box-users">

            <form
                class="form mr-0"
                action="<?=BASE_URL?>admin/newPostSubmit"
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
                    <label for="category">Categoria</label>
                    <select title="category" name="category">
                        <?php foreach($categories as $item): ?>
                            <option value="<?=$item->id?>"><?=$item->name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
    
                <div class="form-item">
                    <label for="title">Título</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        placeholder="Digite o título do post..."
                    />
                </div>

                <div class="form-item">
                    <label for="body">Corpo</label>
                    <textarea
                        class="body-add-post"
                        name="body"
                        id="body"
                        placeholder="Digite o corpo do post..."></textarea>
                </div>

                <div class="form-item">
                    <label for="thumbnail" class="avatar">Thumbnail</label>
                    <input
                        type="file"
                        name="thumbnail"
                        id="thumbnail"
                    />
                </div>
    
                <input type="submit" class="btn" value="Adicionar"/>
            </form>

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
        content_style: 'body { font-family:"Ping Pong",Helvetica,Arial,sans-serif; font-size:18px }'
    });
</script>