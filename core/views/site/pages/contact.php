<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d14715.69763428537!2d-46.2187321!3d-22.768186399999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spt-BR!2sbr!4v1646754560938!5m2!1spt-BR!2sbr" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

<section class="contact">
    <div class="container">
        <h1>Entre em contato</h1>
        <form action="<?=BASE_URL?>/contactFormSubmit" class="form-contact" method="POST">
            <input type="text" name="name" id="name" placeholder="Digite o seu nome..."/>
            <input type="email" name="email" id="email" placeholder="Digite o seu email..."/>
            <input type="text" name="phone" id="phone" placeholder="Digite o seu telefone..."/>
            <textarea name="message" id="message" cols="10" rows="6" placeholder="Digite sua mensagem..."></textarea>
            <input type="submit" value="Enviar"/>
        </form>
    </div>
</section>