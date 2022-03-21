<aside class="navigation menu-lateral">
    <ul>
        <div class="avatar">
            <img
                src="<?=BASE_URL?>admin/assets/images/adminUsers/<?=$loggedAdmin->avatar;?>"
                alt="avatar"
            />
            <span>Admin</span>
        </div>
        <li class="list <?= $activeMenu === "home" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin">
                <span class="icon">
                    <i class="fas fa-home"></i>
                </span>
                <span class="text">Home</span>
            </a>
        </li>
        <?php if($permission === "adminstrador" || $permission === "sub adminstrador"): ?>
            <li class="list <?= $activeMenu === "users" ? "active-menu" : "" ?>">
                <a href="<?=BASE_URL?>admin/users">
                    <span class="icon">
                        <i class="fas fa-user-edit"></i>
                    </span>
                    <span class="text">Usuários</span>
                </a>
            </li>
        <?php endif; ?>
        <li class="list <?= $activeMenu === "testimonials" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/testimonials">
                <span class="icon">
                    <i class="fas fa-comments"></i>
                </span>
                <span class="text">Depoimentos</span>
            </a>
        </li>
        <li class="list <?= $activeMenu === "clients" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/clients">
                <span class="icon">
                    <i class="fas fa-smile"></i>
                </span>
                <span class="text">Clientes</span>
            </a>
        </li>
        <li class="list <?= $activeMenu === "financial" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/financial">
                <span class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </span>
                <span class="text">Financeiro</span>
            </a>
        </li>
        <li class="list <?= $activeMenu === "blog" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/notices">
                <span class="icon">
                    <i class="fas fa-blog"></i>
                </span>
                <span class="text">Blog</span>
            </a>
        </li>
        <li class="list <?= $activeMenu === "products" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/products">
                <span class="icon">
                    <i class="fas fa-store"></i>
                </span>
                <span class="text">Produtos</span>
            </a>
        </li>
        <li class="list <?= $activeMenu === "services" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/services">
                <span class="icon">
                    <i class="fas fa-users-cog"></i>
                </span>
                <span class="text">Serviços</span>
            </a>
        </li>
        <li class="list <?= $activeMenu === "sliders" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/sliders">
                <span class="icon">
                    <i class="fas fa-sliders-h"></i>
                </span>
                <span class="text">Slides</span>
            </a>
        </li>
        <li class="list <?= $activeMenu === "property" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/property">
                <span class="icon">
                    <i class="fas fa-laptop-house"></i>
                </span>
                <span class="text">Imóveis</span>
            </a>
        </li>
        <li class="list <?= $activeMenu === "config" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/config">
                <span class="icon">
                    <i class="fas fa-cog"></i>
                </span>
                <span class="text">Configurações</span>
            </a>
        </li>
        <li class="list <?= $activeMenu === "calendar" ? "active-menu" : "" ?>">
            <a href="<?=BASE_URL?>admin/calendar">
                <span class="icon">
                    <i class="fas fa-calendar"></i>
                </span>
                <span class="text">Calendário</span>
            </a>
        </li>
        <li class="list">
            <a href="<?=BASE_URL?>admin/logout">
                <span class="icon">
                    <i class="fas fa-sign-out-alt"></i>
                </span>
                <span class="text">Sair</span>
            </a>
        </li>
    </ul>
</aside>