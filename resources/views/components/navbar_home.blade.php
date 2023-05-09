<nav class="navbar navbar-expand-lg navbar-light bg-danger sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="">PREMIUM</a>
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
                    <button class="signin-button" style="border-radius: 30px "  onclick="openModal()" href="signin">Sign In</button>
                    <div class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal()">&times;</span>
                            <h2>Welcome back</h2>
                            <label for="email">Email:</label>                      
                        <input type="text" class="form-control form-control-lg bg-light fs-6 mb-3">
                        <label for="Password">Password:</label>
                        <input type="text" class="form-control form-control-lg bg-light fs-6 mb-3">
                        <button type="submit" class="login-button mb-2">Sign In</button>
                        </div>
                    </div>
                </li>
                <button class="start-button" style="border-radius: 30px" onclick="showLogin()">Get Started</button>
                <div id="login-container">
                    <form class="w-50 ">
                        <h2>Welcome!</h2>
                        <h5 class="mb-4">Let's Join Premium</h5>
                        <label for="email">Email:</label>                      
                        <input type="text" class="form-control form-control-lg bg-light fs-6 mb-3">
                        <label for="Password">Password:</label>
                        <input type="text" class="form-control form-control-lg bg-light fs-6 mb-3">
                        <label for="konfirpassword">Konfirmasi Password:</label>
                        <input type="text" class="form-control form-control-lg bg-light fs-6 mb-3">


                      <button type="submit" class="login-button mb-2">Sign Up</button>
                      <button type="submit" class="close-button " style="border-radius: 10px">Close</button>
                    </form>
                  </div>
                  

            </ul>
        </div>
    </div>
</nav>