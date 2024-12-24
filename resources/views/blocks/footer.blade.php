@include('blocks.social-links')

<footer class="mt-5 bg-dark pb-3 pt-2">

    <div class="d-flex justify-content-between align-items-center gap-3 px-4">


        <div class="text-white">
            Desarrollado por <a href="https://wilberth.com" class="text-decoration-none text-info">wilberth.com</a>
        </div>

        <div class="text-white">
            @include('blocks.social-links')
        </div>

    </div>

    <div class="pt-3 bg-dark">
        <div class="row g-4">
            <!--First column-->
            <div class="col-md-4 col-sm-12">
                <div class="footer-card p-4 rounded-3 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-truck fa-2x text-info me-3"></i>
                        <h6 class="text-uppercase fw-bold mb-0 text-white">Envío</h6>
                    </div>
                    <hr class="text-white">
                    <p class="text-white mb-0">
                        Realizamos envíos a todo el país, excepto en zonas excluidas por Correos de
                        Costa Rica.
                    </p>
                </div>
            </div>

            <!--Second column-->
            <div class="col-md-4 col-sm-12">
                <div class="footer-card p-4 rounded-3 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-certificate fa-2x text-warning me-3"></i>
                        <h6 class="text-uppercase fw-bold mb-0 text-white">Autenticidad</h6>
                    </div>
                    <hr class="text-white">
                    <p class="text-white mb-0">
                        Todos nuestros productos son 100% auténticos, ofreciendo el mejor servicio al
                        mejor precio.
                    </p>
                </div>
            </div>

            <!--Third column-->
            <div class="col-md-4 col-sm-12">
                <div class="footer-card p-4 rounded-3 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa fa-shield fa-2x text-success me-3"></i>
                        <h6 class="text-uppercase fw-bold mb-0 text-white">Garantía</h6>
                    </div>
                    <hr class="text-white">
                    <p class="text-white mb-0">
                        Ofrecemos nuestra propia garantía para brindar mayor tranquilidad y respaldo en
                        su compra.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="text-white">
        <div class="mb-0 text-white text-center pb-3">
            © {{ date('Y') }} <a href="https://www.variedadescr.com"
                class="text-decoration-none text-info">VariedadesCR.com</a>
        </div>
    </div>

</footer>
