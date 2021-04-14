<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
    <div class="container">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <!-- Start Newsletter Inner -->
                    <div class="inner">
                        <h4>Newsletter</h4>
                        <p> Inscreva-se no nosso Newsletter e ganhe <span>10%</span> de desconto na sua primeira compra</p>
                        <form action="#" method="POST" class="newsletter-inner">
                            @csrf
                            <input name="email" placeholder="Seu endereço de e-mail" type="email" required>
                            <button class="btn" type="submit">Inscreva-se</button>
                        </form>
                    </div>
                    <!-- End Newsletter Inner -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Newsletter -->
