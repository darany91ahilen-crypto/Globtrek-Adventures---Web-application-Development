</main>

<footer class="footer">
    <div class="container footer-grid">

        <div>
            <h3> <img src="http://localhost/globetrek/assets/images/logo.jpeg" 
         alt="GlobeTrek Adventures" 
         class="footer-logo-img"> GlobeTrek Adventures </h3>
            <p>Explore this Pearl Paradise with us</p>
        </div>

    

<div>
    <h4>Customer</h4>
    <a href="http://localhost/globetrek/index.php?url=auth/register">
        &rsaquo; Register
    </a>
    <a href="http://localhost/globetrek/index.php?url=auth/login">
        &rsaquo; Login
    </a>
    <a href="http://localhost/globetrek/index.php?url=customer/mybookings">
        &rsaquo; My Bookings
    </a>
    <a href="http://localhost/globetrek/index.php?url=customer/query">
        &rsaquo; Submit Query
    </a>
</div>
        


        <div>
            <h4>
                <i class="fas fa-address-book"></i>
                Contact 
            </h4>

            <p>
                <i class="fas fa-map-marker-alt"></i>
                Negombo, Western Province, Sri Lanka
            </p>

            <p>
                <i class="fas fa-phone-alt"></i>
                <a href="tel:+94764279445"
                style="color:rgba(255,255,255,0.8);
                        text-decoration:none;">
                    +94 74 26 65 529
                </a>
            </p>

            <p>
                <i class="fas fa-envelope"></i>
                <a href="mailto:hello@globetrekadventures.lk"
                style="color:rgba(255,255,255,0.8);
                        text-decoration:none;">
                    darany91ahilen@gmail.com
                </a>
            </p>

            <p>
                <i class="fas fa-globe"></i>
                www.globetrekadventures.lk
            </p>

            <p>
                <i class="fas fa-clock"></i>
                Mon–Sat: 9am – 6pm
            </p>
        </div>

  
<div class="social-icons" style="margin-top:1rem;">
    <a href="https://www.facebook.com/share/18MYwyu8Ju/"
       target="_blank"
       title="Facebook">
        <i class="fab fa-facebook-f"></i>
    </a>
    <a href="https://www.instagram.com/globetk.adventure?utm_source=qr&igsh=OGR1ZWQyMzl6aW1r"
       target="_blank"
       title="Instagram">
        <i class="fab fa-instagram"></i>
    </a>
    <a href="https://wa.me/94742665529"
       target="_blank"
       title="WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>
            

    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> GlobeTrek Adventures. Designed with in Negombo All Rights Reserved.</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const mainNav = document.querySelector('#main-nav');

    if (!menuToggle || !mainNav) {
        return;
    }

    menuToggle.addEventListener('click', function () {
        const isOpen = mainNav.classList.toggle('is-open');
        menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        menuToggle.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
    });
});
</script>

</body>
</html>