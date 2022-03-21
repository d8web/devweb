<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Arial", sans-serif;
        }
        body {
            max-width: 900px;
            margin: auto;
        }
        .wrapper {
            overflow-x: auto;
        }

        .wrapper table {
            width: 100%;
            margin-top: 20px;
            border: 1px solid #ccc;
            border-collapse: collapse;
        }
        h2 {
            padding: 10px;
            background-color: #333;
            color: #efefef;
        }
        th, td {
            text-align: left;
            height: 40px;
            border-bottom: 1px solid #ccc;
            padding: 10px;
        }
        .text-right {
            text-align: right;
        }
    </style>
    <title>PDF</title>
</head>
<body>
    
    <div class="wrapper">
        <h2>Pagamentos <?=$type?></h2>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Cliente</th>
                    <th>Valor</th>
                    <th class="text-right">Vencimento</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($paymentsClient as $item): ?>
                    <tr>
                        <td><?=$item->name?></td>
                        <td><?=$item->clientName?></td>
                        <td><?=$item->value?></td>
                        <td class="text-right"><?=date("d/m/Y", strtotime($item->expired))?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</body>
</html>