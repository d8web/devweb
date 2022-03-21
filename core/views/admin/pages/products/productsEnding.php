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


        <div class="founded">
            <h4>Produtos <?=($type === "ending") ? 'com estoque acabando!' : 'sem estoque!'?>.</h4>
        </div>

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
                            <img src="<?= BASE_URL ?>assets/images/products/<?= $item->image ?>" alt="<?= $item->name ?>" />
                        </div>
                        <div class="product-info">
                            <h2><?= $item->name ?></h2>
                            <span>R$ <?= number_format($item->price, 2, ",", ".") ?></span>
                        </div>
                        <div class="product-footer">
                            <a class="edit-prod" href="<?= BASE_URL ?>admin/editProduct?id=<?= Functions::aesEncrypt($item->id) ?>">Editar</a>
                            <a class="del-prod" onclick="return confirm('Deseja realmente excluir este produto?')" href="<?= BASE_URL ?>admin/delProduct?id=<?= Functions::aesEncrypt($item->id) ?>">Excluir</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <p>Nenhum produto para mostrar</p>
            <?php endif ?>

        </section>

        <?php if (count($products["list"]) > 0) : ?>
            <div class="pagination-blog">
                <nav>
                    <ul>
                        <?php for ($q = 0; $q < $products["pageCount"]; $q++) : ?>
                            <li>
                                <a
                                    class="<?= ($q + 1 == $products["currentPage"]) ? 'active-page' : '' ?>"
                                    href="<?= BASE_URL ?>admin/showProducts?type=<?=$_GET["type"]?>&page=<?= $q + 1 ?>">
                                    <?= $q + 1 ?>
                                </a>
                            </li>
                        <?php endfor ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>

    </section>

</section>