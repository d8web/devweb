<?php

use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], ["loggedAdmin" => $loggedAdmin]); ?>

    <section class="p-30 users pt-80">

        <div class="title">
            <h1>Produtos</h1>
            <a class="btn btn-large" href="<?= BASE_URL ?>admin/newProduct">Adicionar produto</a>
        </div>

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

        <div class="search-container">
            <form action="<?=BASE_URL?>admin/searchProduct" method="GET">
                <div class="form-item">
                    <label for="name">Pesquisar produto</label>
                    <input
                        type="search"
                        name="search"
                        id="search"
                        placeholder="Pesquisar produto..."
                        value="<?=isset($searchTerm) && !empty($searchTerm) ? $searchTerm : ""?>"
                    />
                </div>

                <input class="btn" type="submit" value="Pesquisar"/>
            </form>
        </div>

        <?php if(isset($searchTerm) && !empty($searchTerm)): ?>
            <div class="founded">
                <?php if(count($products["list"]) == 1): ?>
                    <h4>Foi encontrado <span><?=$products["total"]?></span> resultado com o termo <span><?=$searchTerm?></span>.</h4>
                <?php elseif(count($products["list"]) > 1): ?>
                    <h4>Foram encontrados <span><?=$products["total"]?></span> resultados com o termo <span><?=$searchTerm?></span>.</h4>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if($productsEnding): ?>
            <div class="box-alert-product alert-warning">
                <h2>Alguns produtos estão acabando! <a href="<?=BASE_URL?>admin/showProducts?type=ending">Ver produtos</a></h2>
            </div>
        <?php endif; ?>

        <?php if($productsNotStock): ?>
            <div class="box-alert-product alert-danger">
                <h2>Alguns produtos estão sem estoque! <a href="<?=BASE_URL?>admin/showProducts?type=notStock">Ver produtos</a></h2>
            </div>
        <?php endif; ?>

        <section class="products-container">
            <?php if (count($products["list"]) > 0) : ?>
                <?php foreach ($products["list"] as $item) : ?>
                    <div class="product-box">
                        <?php if($item->stock <= 5 && $item->stock > 0): ?>
                            <div class="alert-box-product warning">Acabando</div>
                        <?php endif ?>
                        <?php if($item->stock === 0): ?>
                            <div class="alert-box-product danger">Em falta</div>
                        <?php endif ?>
                        <div class="product-header">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="product-image-container">
                            <img
                                src="<?= BASE_URL ?>assets/images/products/<?=$item->image?>"
                                alt="<?= $item->name ?>"
                            />
                        </div>
                        <div class="product-info">
                            <h2><?= $item->name ?></h2>
                            <span>R$ <?= number_format($item->price, 2, ",", ".") ?></span>
                        </div>
                        <div class="product-footer">
                            <a
                                class="edit-prod"
                                href="<?=BASE_URL?>admin/editProduct?id=<?=Functions::aesEncrypt($item->id)?>"
                            >Editar</a>
                            <a
                                class="del-prod"
                                onclick="return confirm('Deseja realmente excluir este produto?')"
                                href="<?=BASE_URL?>admin/delProduct?id=<?=Functions::aesEncrypt($item->id)?>"
                            >Excluir</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <p>Nenhum produto para mostrar</p>
            <?php endif ?>

        </section>

        <?php if(count($products["list"]) > 0) : ?>
            <div class="pagination-blog">
                <nav>
                    <ul>
                        <?php for($q=0;$q<$products["pageCount"];$q++) : ?>
                            <li>
                                <?php if($search): ?>
                                    <a
                                        class="<?=($q + 1 == $products["currentPage"]) ? 'active-page':''?>"
                                        href="<?=BASE_URL?>admin/searchProduct?search=<?=$_GET["search"]?>&page=<?=$q+1?>">
                                        <?= $q + 1 ?>
                                    </a>
                                <?php endif; ?>
                                <?php if($productsPage): ?>
                                    <a
                                        class="<?=($q+1 == $products["currentPage"]) ? 'active-page':''?>"
                                        href="<?=BASE_URL ?>admin/products?page=<?=$q+1?>">
                                        <?=$q+1?>
                                    </a>
                                <?php endif ?>
                            </li>
                        <?php endfor ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>

    </section>

</section>