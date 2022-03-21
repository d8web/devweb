<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 pt-80">
        
        <div class="title">
            <h1>Dashboard</h1>
            <a
                class="btn"
                href="<?=BASE_URL?>"
                target="_blank"
            >Ver site</a>
        </div>

        <div class="admin-boxes">
            <div class="box">
                <div class="users-online">
                    <h3>Usuários online</h3>
                    <span><?=count($listUsersOnline)?></span>
                </div>
            </div>
            <div class="box">
                <div class="visits">
                    <h3>Novas visitas</h3>
                    <span><?=count($totalAccountantUsersVisitsToday)?></span>
                </div>
            </div>
            <div class="box">
                <div class="visits">
                    <h3>Total de visitas</h3>
                    <span><?=count($totalAccountantUsersVisits)?></span>
                </div>
            </div>
            <div class="box">
                <div class="visits">
                    <h3>Total de usuários</h3>
                    <span><?=count($usersList)?></span>
                </div>
            </div>
        </div>

        <div class="title margin-top-table border-top-table">
            <h1>Usuários online</h1>
        </div>

        <?php if(count($listUsersOnline) > 0): ?>
            <div class="wrapper-table-client-payments">
                <table class="table-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IP</th>
                            <th>Última ação</th>
                            <th class="text-end">Token</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listUsersOnline as $item): ?>
                            <tr>
                                <td><?=$item->id?></td>
                                <td><?=$item->ip?></td>
                                <td><?=date("d/m/Y H:i:s", strtotime($item->lastaction))?></td>
                                <td class="text-end"><?=$item->token?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-dark">Nenhum usuário está online no momento!</p>
        <?php endif ?>

        <div class="title margin-top-table border-top-table">
            <h1>Usuários cadastrados</h1>
        </div>

        <?php if(count($usersList) > 0): ?>
            <div class="wrapper-table-client-payments">
                <table class="table-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th class="text-end">Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usersList as $item): ?>
                            <tr>
                                <td><?=$item->id?></td>
                                <td><?=$item->name?></td>
                                <td><?=$item->email?></td>
                                <td class="text-end">
                                    <?=ucfirst(PERMISSIONS[$item->adminField])?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-dark">Nenhum usuário cadastrado!</p>
        <?php endif ?>

    </section>

</section>