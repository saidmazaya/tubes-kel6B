<nav class="navbar navbar-expand-lg navbar-light bg-danger sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="#">PREMIUM</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="ourstory">Our Story</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="homewrite">Write</a>
                </li>
                <li class="nav-item">
                    <button class="signin-button" style="border-radius: 30px" onclick="openModal()">Sign In</button>
                    <div class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <h2>Welcome back</h2>
                            <div class="google-login">
                                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg"
                                    alt="Google Sign In">
                                <button>Sign In with Google</button>
                            </div>
                        </div>
                    </div>
                </li>
                <button class="start-button" style="border-radius: 30px" onclick="openModal()" php>Get Started</button>
            </ul>
        </div>
    </div>
</nav>