<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">
        
        <div class="title">
            <h1>Imóveis</h1>
            <a
                class="btn btn-large"
                href="<?=BASE_URL?>admin/newProperty"
            >Adicionar imóvel</a>
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
            <form action="<?=BASE_URL?>admin/searchProperty" method="GET">
                <div class="form-item">
                    <label for="name">Pesquisar propriedade</label>
                    <input
                        type="search"
                        name="search"
                        id="search"
                        placeholder="Pesquisar propriedade..."
                        value="<?=isset($searchTerm) && !empty($searchTerm) ? $searchTerm : ""?>"
                    />
                </div>

                <input class="btn" type="submit" value="Pesquisar"/>
            </form>
        </div>

        <?php if(isset($searchTerm) && !empty($searchTerm)): ?>
            <div class="founded">
                <?php if(count($properties["list"]) == 1): ?>
                    <h4>Foi encontrado <span><?=$properties["total"]?></span> resultado com o termo <span><?=$searchTerm?></span>.</h4>
                <?php elseif(count($properties["list"]) > 1): ?>
                    <h4>Foram encontrados <span><?=$properties["total"]?></span> resultados com o termo <span><?=$searchTerm?></span>.</h4>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <section class="products-container">
            <?php if (count($properties["list"]) > 0) : ?>
                <?php foreach ($properties["list"] as $item) : ?>
                    <div class="product-box">
                        <h5><?=$item->type == "commertial" ? "Comercial" : "Residencial"?></h5>
                        <div class="product-property-container">
                            <img src="<?= BASE_URL ?>assets/images/properties/<?= $item->image ?>" alt="<?= $item->name ?>" />
                        </div>
                        <div class="product-info">
                            <h2><?= $item->name ?></h2>
                            <span>R$ <?=number_format(intval($item->price), 2, ",", ".")?></span>
                        </div>
                        <div class="product-footer">
                            <a
                                class="edit-prod"
                                href="<?=BASE_URL?>admin/editProperty?id=<?=Functions::aesEncrypt($item->id)?>"
                            >Ver</a>
                            <a
                                class="del-prod"
                                onclick="return confirm('Deseja realmente excluir este produto?')"
                                href="<?=BASE_URL?>admin/delProperty?id=<?=Functions::aesEncrypt($item->id)?>"
                            >Excluir</a>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php else : ?>
                <p>Nenhum produto para mostrar</p>
            <?php endif ?>

        </section>

        <?php if (count($properties["list"]) > 0) : ?>
            <div class="pagination-blog">
                <nav>
                    <ul>
                        <?php for ($q = 0; $q < $properties["pageCount"]; $q++) : ?>
                            <li>
                                <?php if($search): ?>
                                    <a
                                        class="<?= ($q + 1 == $properties["currentPage"]) ? 'active-page' : '' ?>"
                                        href="<?= BASE_URL ?>admin/searchProperty?search=<?=$_GET["search"]?>&page=<?= $q + 1 ?>">
                                        <?= $q + 1 ?>
                                    </a>
                                <?php endif; ?>
                                <?php if($propertiesPage): ?>
                                    <a
                                        class="<?= ($q + 1 == $properties["currentPage"]) ? 'active-page' : '' ?>"
                                        href="<?= BASE_URL ?>admin/property?page=<?= $q + 1 ?>">
                                        <?= $q + 1 ?>
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