<section class="hero">
    <div class="slider">
        <div class="slider-controls">
            <div class="slider-control" onClick="goPrev()"><i class="fas fa-arrow-left"></i></div>
            <div class="slider-control" onClick="goNext()"><i class="fas fa-arrow-right"></i></div>
        </div>
        <div class="slider-width">

            <?php foreach($sliders as $item): ?>
                <div style="background-image: linear-gradient(to top, rgba(0,112,243, .5), rgba(0,112,243,.6)), url('<?=BASE_URL?>/assets/images/sliders/<?=$item->url?>');" class="slider-item">
                    <div class="container">
                        <form action="<?=BASE_URL?>/send" method="POST" autocomplete="off" name="signin">
                            <h2>Digite seu email</h2>
                            <input type="email" id="email" name="email" placeholder="Digite seu email..." autofocus required />
                            <input type="submit" value="Cadastrar"/>
                        </form>
                    </div>
                </div>
            <?php endforeach ?>

        </div>
    </div>
</section>

<section class="about" id="about">
    <div class="container flex flex-column align-center">
        <div class="w50 p-10">
            <h2><?=$about->nameAuthor?></h2>
            <p class="fs-20"><?=nl2br($about->description)?></p>
        </div>
        <div class="w50 p-10 justify-end">
            <img
                class="img-about"
                src="<?=BASE_URL?>/assets/images/about/<?=$about->image?>"
                alt="about"
            />
        </div>
    </div>
</section>

<section class="services" id="services">
    <h2 class="text-center text-light">Serviços</h2>
    <div class="container flex flex-wrap">

        <?php foreach($services as $key => $item): ?>
            <div class="box p-10">
                <i class="<?=$item->icon?>"></i>
                <h3><?=$item->title?></h3>
                <p class="fs-20"><?=$item->body?></p>
            </div>
        <?php endforeach ?>

    </div>
</section>

<section class="extras">
    <div class="container flex flex-column">
        <div class="w50 p-10">
            <h2 class="title">Testemunhas</h2>

            <?php foreach($testimonials as $key => $item): ?>
                <?php if($key <= 2): ?>
                    <div class="testimonial-single">
                        <p class="fs-20"><?=$item->body?></p>
                        <p class="author"><?=$item->author?></span>
                    </div>
                <?php endif ?>
            <?php endforeach ?>

        </div>
        <div class="w50 p-10">
            <ul>
                <h2 class="title">Outras Informações</h2>
                <li class="fs-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus minus ut eum assumenda porro rem et officia quibusdam recusandae! Accusamus neque aliquam ad, sed ex debitis alias itaque provident similique.</li>
                <li class="fs-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus minus ut eum assumenda porro rem et officia quibusdam recusandae! Accusamus neque aliquam ad, sed ex debitis alias itaque provident similique.</li>
                <li class="fs-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus minus ut eum assumenda porro rem et officia quibusdam recusandae! Accusamus neque aliquam ad, sed ex debitis alias itaque provident similique.</li>
                <li class="fs-20">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque natus minus ut eum assumenda porro rem et officia quibusdam recusandae! Accusamus neque aliquam ad, sed ex debitis alias itaque provident similique, optio corporis quaerat, omnis natus est reprehenderit iste ipsum rem et officia quibusdam recusandae.</li>
            </ul>
        </div>
    </div>
</section>

<?php if(!empty($flash)): ?>
    <div class="message">
        <?=$flash;?>
    </div>
<?php endif; ?>

<div class="message"></div>
<div class="error"></div>

<?php if(!empty($error)): ?>
    <div class="error">
        <?=$error;?>
    </div>
<?php endif; ?>

<div class="loading">
    <img src="<?=BASE_URL?>/assets/images/loading.gif" alt="loading"/>
</div>

<script>

    const formSignIn = document.forms.signin

    formSignIn.addEventListener("submit", (e) => {

        e.preventDefault();
        let email = document.getElementById("email").value
        
        if(email) {
            const request = async () => {
                document.querySelector(".loading").style.display = "flex"
        
                let result = await fetch("<?=BASE_URL?>/sendByJs", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({email})
                })
        
                let json = await result.json();
                if(json.success) {
                    let messageDiv = document.querySelector(".message")
                    // console.log(messageDiv)
                    messageDiv.style.display = "flex"
                    messageDiv.innerText = "Email enviado com sucesso!";

                    setInterval(() => {
                        messageDiv.style.top = `-${500}px`
                        messageDiv.style.display = 0
                    }, 5000)
                    // Limpando o campo do input
                    document.getElementById("email").value = ""
                } else {
                    let messageDiv = document.querySelector(".error")
                    // console.log(messageDiv)
                    messageDiv.style.display = "flex"
                    messageDiv.innerText = "Ocorreu um erro!";

                    setInterval(() => {
                        messageDiv.style.top = `-${500}px`
                        messageDiv.style.display = 0
                    }, 5000)
                    // Limpando o campo do input
                    document.getElementById("email").value = ""
                }
                // console.log(json)
                document.querySelector(".loading").style.display = "none"
            }

            request()
        }
    })

</script>