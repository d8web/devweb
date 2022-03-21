<?php use core\helpers\Functions; ?>
<section class="blog-container">
    <div class="container">
        <div class="banner-blog">
            <i class="far fa-bell"></i>
            <h1>Acompanhe as <b>últimas notícias</b> do portal</h1>
        </div>
    </div>
</section>

<div class="container">
    <div class="title-blog">
        <?php if($categorySelected !== ""): ?>
            <h2>Visualizando posts da categoria <span><?=$categorySelected?></span>.</h2>
        <?php endif ?>
        <?php if($blog): ?>
            <h2>Visualizando todos os posts.</h2>
        <?php endif ?>
        <?php if($searchTerm): ?>
            <h2>Visualizando todos os posts pelo termo <span><?=$search?></span>.</h2>
        <?php endif ?>
    </div>
</div>

<section class="container-blog">
    <div class="container">
        <div class="content-blog">
            <aside class="sidebar">

                <div class="box-content-sidebar">
                    <h3>Pesquisar <i class="fa fa-search"></i></h3>
                    <form action="" method="get">
                        <input
                            type="search"
                            name="search"
                            id="search"
                            placeholder="Pesquisar..."
                            value="<?=isset($search) && !empty($search) ? $search : ''?>"
                        />
                        <input type="submit" class="search" value="Pesquisar"/>
                    </form>
                </div>

                <div class="box-content-sidebar">
                    <h3>Selecionar <i class="fa fa-list"></i></h3>
                    <form action="" method="get">
                        <select
                            name="category"
                            title="category"
                            id="category"
                            onchange="this.form.submit()"
                        >
                            <option value="">Selecionar categoria</option>
                            <?php foreach($categories as $item): ?>
                                <option
                                    value="<?=Functions::aesEncrypt($item->id)?>"
                                    <?= ($categorySelected === $item->name) ? "selected" : ""?>
                                >
                                    <?=$item->name?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>

                <div class="box-content-sidebar">
                    <h2>Conheça o autor</h3>
                    <div class="author-box-blog">
                        <img src="<?=BASE_URL?>assets/images/about/<?=$info->image?>" alt="author"/>
                        <strong><?=$info->nameAuthor?></strong>
                        <p><?=substr($info->description, 0, 120)?>...</p>
                    </div>
                </div>

            </aside>
            <section class="notices-area">
                
                <?php if(count($posts["posts"]) > 0): ?>
                    <?php foreach($posts["posts"] as $item):?>
                        <a href="<?=BASE_URL?>post?slug=<?=$item->slug?>" class="single-box-notice">
                            <div class="thumb-blog">
                                <img src="<?=BASE_URL?>assets/images/posts/<?=$item->thumbnail?>" alt="post">
                            </div>
                            <div class="box-info-blog">
                                <h2><?=substr($item->title, 0, 30)?>... <span><?=$item->categoryName?></span></h2>
                                <p>
                                    <?=substr(strip_tags($item->body), 0, 240)?>...
                                </p>
                                <div class="footer-box-info-blog">
                                    <span><strong>Autor: </strong><?=$item->userName?></span>
                                    <span><strong>Data: </strong><?=date("d/m/Y", strtotime($item->created_at))?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach ?>
                    
                    <div class="pagination-blog">
                        <nav>
                            <ul>
                                <?php for($q = 0; $q < $posts["pageCount"]; $q++): ?>
                                    <li>
                                        <?php if($categoryUrl): ?>
                                            <a
                                                class="<?=($q+1 == $posts["currentPage"]) ? 'active-page' : '' ?>"
                                                href="<?=BASE_URL?>blog?category=<?=$_GET["category"]?>&page=<?=$q+1?>"
                                            >
                                                <?=$q+1?>
                                            </a>
                                        <?php endif ?>
                                        <?php if($searchTerm): ?>
                                            <a
                                                class="<?=($q+1 == $posts["currentPage"]) ? 'active-page' : '' ?>"
                                                href="<?=BASE_URL?>blog?search=<?=$_GET["search"]?>&page=<?=$q+1?>"
                                            >
                                                <?=$q+1?>
                                            </a>
                                        <?php endif ?>
                                        <?php if($blog): ?>
                                            <a
                                                class="<?=($q+1 == $posts["currentPage"]) ? 'active-page' : '' ?>"
                                                href="<?=BASE_URL?>blog?page=<?=$q+1?>"
                                            >
                                                <?=$q+1?>
                                            </a>
                                        <?php endif ?>
                                    </li>
                                <?php endfor ?>
                            </ul>
                        </nav>
                    </div>

                <?php else: ?>
                    <p>Nenhum post para ser exibido!</p>
                <?php endif ?>                

            </section>
        </div>
    </div>
</section>