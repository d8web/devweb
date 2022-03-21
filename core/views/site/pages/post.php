<?php use core\helpers\Functions; ?>
<section class="blog-container">
    <div class="container">
        <div class="banner-blog">
            <i class="far fa-bell"></i>
            <h1>Acompanhe as <b>últimas notícias</b> do portal.</h1>
        </div>
    </div>
</section>

<section class="post">
    <div class="container">
        <div class="single-notice-item-content">
            <div class="notice-area-content">
                <h1><?=$post->title?></h1>
                <img src="<?=BASE_URL?>assets/images/posts/<?=$post->thumbnail?>" alt="post-thumbnail"/>
                <div class="post-body">
                    <?=nl2br($post->body)?>
                </div>
                <div class="info-single-post-content">
                    <span><strong>Author</strong> <?=$post->userName?></span>
                    <span><strong>Data</strong> <?=date("d/m/Y", strtotime($post->created_at))?></span>
                </div>

                <?php if(!$isLogged): ?>
                    <div class="info-not-logged">
                        Fazer login para comentar! <a href="<?=BASE_URL?>signIn?slug=<?=$_GET["slug"]?>">Login</a>
                    </div>
                <?php else: ?>
                    <div class="comments-container">
                        <h3>Adicionar comentário &nbsp;<i class="fa fa-comment"></i></h3>
                        <form action="" class="form-post">
                            <input type="text" name="name" id="name" placeholder="Digite seu nome" value="<?=$isLogged->name?>" disabled />
                            <textarea name="comment" id="comment" placeholder="Digite seu comentário"></textarea>

                            <input type="hidden" name="userId" id="userId" value="<?=Functions::aesEncrypt($isLogged->id)?>"/>
                            <input type="hidden" name="noticeId" id="noticeId" value="<?=Functions::aesEncrypt($post->id)?>"/>
                            <input type="submit" value="Comentar"/>
                        </form>

                        <div class="comments-content">

                            <h3>Comentários do post &nbsp;<i class="fa fa-comment"></i></h3>

                            <?php if(count($comments) > 0): ?>
                                <?php foreach($comments as $item): ?>
                                    <div class="info-comment">
                                        <div class="user-avatar-comment">
                                            <img
                                                src="<?=BASE_URL?>assets/images/users/<?=$item->userAvatar?>"
                                                alt="<?=$item->userName?>"
                                            />
                                        </div>
                                        <div class="name-and-comment">
                                            <span><?=$item->userName?></span>
                                            <p><?=$item->comment?></p>
                                            <strong><?=date("d/m/Y", strtotime($item->created_at))?></strong>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php else: ?>
                                <div>Este post ainda não possuí comentários!</div>
                            <?php endif ?>

                        </div>

                    </div>
                <?php endif ?>
                
            </div>
            <aside class="adsense">
                <a href=""><img src="https://alunos.b7web.com.br/media/courses/php.jpg" /></a>
                <a href=""><img src="https://alunos.b7web.com.br/media/courses/laravel.jpg" /></a>
                <a href=""><img src="https://alunos.b7web.com.br/media/courses/javascript.jpg" /></a>
                <a href=""><img src="https://alunos.b7web.com.br/media/courses/typescript.jpg" /></a>
            </aside>
        </div>
    </div>
</section>

<script>

    const formComment = document.querySelector(".form-post")
    formComment.addEventListener("submit", e => {

        e.preventDefault()

        let name = document.getElementById("name").value
        if(name.length === 0) {
            alert("O nome precisa ser preenchido");
            return;
        }

        let comment = document.getElementById("comment").value
        if(comment.length <= 1) {
            alert("Digite um comentário com pelo menos 2 caracteres!")
            return;
        }
        
        let userId = document.getElementById("userId").value
        if(userId.length !== 32) {
            alert("Id do usuário precisa ter pelo menos 32 caracteres!")
            return;
        }

        let noticeId = document.getElementById("noticeId").value
        if(noticeId.length !== 32) {
            alert("Id do post precisa ter pelo menos 32 caracteres!")
            return;
        }

        // Fazer requisição para adicionar o comentário
        const addCommentInPost = async (userId, noticeId, comment) => {

            let body = {
                userId,
                noticeId,
                comment
            }

            let result = await fetch("<?=BASE_URL?>newComment", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(body)
            })
        
            let json = await result.json();
            if(json.success) {
                window.location.reload()
            }

        }

        addCommentInPost(userId, noticeId, comment)

    })

</script>