<?php use core\helpers\Functions; ?>

<section class="content">

    <?= Functions::RenderAdmin([
        "partials/navbar"
    ], [ "loggedAdmin" => $loggedAdmin ]); ?>

    <section class="p-30 users pt-80">

        <div class="title">
            <h1>Calendário | <?=$monthList[$month - 1]?>/<?=$year?></h1>
            <div class="d-flex align-center">
                <a href="<?=BASE_URL?>admin/calendar?month=<?=$month-1?>&year=<?=date("Y", time())?>" class="btn btn-sm mr-10">Anterior</a>
                <a href="<?=BASE_URL?>admin/calendar?month=<?=$month+1?>&year=<?=date("Y", time())?>" class="btn btn-sm">Próximo</a>
            </div>
        </div>

        <div class="table-calendar">
            <table class="calendar-table">
                <thead>
                    <tr>
                        <th>Domingo</th>
                        <th>Segunda</th>
                        <th>Terça</th>
                        <th>Quarta</th>
                        <th>Quinta</th>
                        <th>Sexta</th>
                        <th>Sábado</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php
                        $n = 1;
                        $z = 0;
                        $numberOfDays += $dayOneFromMonth;

                        while($n <= $numberOfDays) {
                            if($dayOneFromMonth == 7 && $z != $dayOneFromMonth) {
                                $z = 7;
                                $n = 8;
                            }
                            
                            if($n % 7 == 1) {
                                echo "<tr>";
                            }

                            if($z >= $dayOneFromMonth) {
                                $day = $n - $dayOneFromMonth;
                                if($day < 10) {
                                    $day = str_pad($day, strlen($day) + 1, "0", STR_PAD_LEFT);
                                }
                                $current = "$year-$month-$day";
                                if($current !== $today) {
                                    echo "<td day=\"$current\">$day</td>";
                                } else {
                                    echo '<td day="'.$current.'" class="day-selected">'.$day.'</td>';
                                }

                            } else {
                                echo "<td></td>";
                                $z++;
                            }

                            if($n % 7 == 0) {
                                echo "</tr>";
                            }
                            $n++;
                        }
                    ?>

                </tbody>
            </table>
        </div>

        <div class="d-flex mb-20 flex-responsive">
            <a
                href="<?=BASE_URL?>admin/calendar?month=<?=isset($_GET["month"]) ? $_GET["month"] : date("m", time())?>&year=<?=$year - 1?>"
                class="btn mr-10"
            >Ano anterior</a>
            <a
                href="<?=BASE_URL?>admin/calendar?month=<?=isset($_GET["month"]) ? $_GET["month"] : date("m", time())?>&year=<?=$year + 1?>"
                class="btn"
            >Proximo ano</a>
        </div>

        <form action="" class="form-calendar" method="">
            <h2 class="title-todo">Adicionar tarefa no dia <?=date("d/m/Y", time())?></h2>

            <div class="form-item">
                <label for="todo">Tarefa</label>
                <input type="text" name="todo" id="todo" placeholder="Nome da tarefa..." />
            </div>

            <input type="hidden" name="date" id="date-hidden" value="<?=date("Y-m-d", time())?>"/>

            <input type="submit" class="btn" value="Adicionar"/>

        </form>

        <h2 class="title-todo" id="todo-of-day">Tarefas do dia <?=date("d/m/Y", time())?></h2>
        <div class="todo-container">
            <?php foreach($todosToday as $item): ?>
                <div class="todo-single">
                    <span><i class="fas fa-edit"></i> <?=$item->todo?></span>
                </div>
            <?php endforeach ?>
        </div>

    </section>

</section>

<script>
    
    let tableColuns = document.querySelectorAll("td")
    tableColuns.forEach(item => {
        item.addEventListener("click", e => {
            
            tableColuns.forEach(td => {
                td.classList.remove("day-selected")
            })
            
            e.target.classList.add("day-selected")
            let dateNotFormated = e.target.getAttribute("day")
            let newDay = dateNotFormated.split("-")
            let newDayFormated = `${newDay[2]}/${newDay[1]}/${newDay[0]}`
            
            replaceDate(dateNotFormated, newDayFormated)
            getTodosFromDate(dateNotFormated);

        })
    })

    const replaceDate = (dateNotFormated, dateFormated) => {
        document.querySelector("input[type=hidden]").value = dateNotFormated
        document.querySelector("form.form-calendar h2").innerHTML = `Adicionar tarefa no dia ${dateFormated}`
        document.getElementById("todo-of-day").innerHTML = `Tarefas do dia ${dateFormated}`
    }

    const getTodosFromDate = async (dateNotFormated) => {

        let result = await fetch("<?=BASE_URL?>admin/getTodosByDate", {
            method: "POST",
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({dateNotFormated})
        })

        let json = await result.json()
        // console.log(json)
        if(!json.error) {
            document.querySelector(".todo-container").innerHTML = ""

            json.todos.forEach(item => {
                let html = '<div class="todo-single"><span><i class="fas fa-edit"></i>'
                html += item.todo + "</span></div>"
                document.querySelector(".todo-container").innerHTML += html
            })
        }

    }

    let formNewTodo = document.querySelector(".form-calendar")
    formNewTodo.addEventListener("submit", e => {

        e.preventDefault();

        let todoField = document.getElementById("todo").value
        if(todoField.length <= 3) {
            alert("Preencha uma tarefa com mais de 3 caracteres!")
            return
        }

        let inputFieldDate = document.getElementById("date-hidden").value
        let inputFieldArray = inputFieldDate.split("-")
        if(inputFieldArray.length != 3) {
            alert("Data inválida!")
            return
        }

        const addNewTodo = async (todoField, inputFieldDate) => {

            let body = {
                todo: todoField,
                date: inputFieldDate
            }

            let result = await fetch("<?=BASE_URL?>admin/newTodo", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(body)
            })

            let json = await result.json()
            
            if(!json.error) {
                getTodosFromDate(inputFieldDate)
                document.getElementById("todo").value = ""
                return;
            } else {
                alert(json.message)
                return;
            }

        }

        addNewTodo(todoField, inputFieldDate)

    })

</script>