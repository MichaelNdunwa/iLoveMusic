<div id="navBarContainer">
    <nav class="navBar">
        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
            <img src="assets/images/logo.png">
        </span>

        <div class="group">
            <div class="navItem">
                <span role='link' tabindex='0' onclick='openPage("search.php")' class="navItemLink"><i
                        class="fa-solid fa-magnifying-glass"></i>Search</span>
            </div>
        </div>
        <div class="group">
            <div id="browse" class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink"><i
                        class="fa-solid fa-music"></i>Music</span>
            </div>
            <!-- <div id="yourMusic" class="navItem">
                <span role="link" tabindex="0" onclick="openPage('yourMusic.php')" class="navItemLink"><i class="fa-solid fa-music"></i>Your Music</span>
            </div> -->
            <div id="video" class="navItem">
                <span role="link" tabindex="0" onclick="openPage('video.php')" class="navItemLink"><i
                        class="fa-solid fa-video"></i>Video</span>
            </div>
            <!-- <div id="profile" class="navItem">
                <span role="link" tabindex="0" onclick="openPage('profile.php')" class="navItemLink"><i class="fa-solid fa-user"></i>the_organizer</span>
            </div> -->
            <div id="contact" class="navItem">
                <span role="link" tabindex="0" onclick="openPage('contact.php')" class="navItemLink"><i
                        class="fa-solid fa-paper-plane"></i>Contact</span>
            </div>
            <div id="logout" class="navItem">
                <span role="link" tabindex="0" onclick="showLogoutDialog()" class="navItemLink"><i
                        class="fa-solid fa-right-from-bracket"></i>I dare you to logout</span>
            </div>
        </div>
    </nav>
</div>

<div class="dialog-overlay" id="logoutDialog">
    <div class="dialog-container">
        <h2 class="dialog-title">Are sure you want to bounce out?</h2>
        <p class="dialog-message">You'll need to log back in to access your music and videos.</p>
        <div class="dialog-buttons">
            <button class="button button-cancel" onclick="hideLogoutDialog()">Cancel</button>
            <button class="button button-logout" onclick="logout()">Logout</button>
        </div>
    </div>
</div>

<script>
    function showLogoutDialog() {
        document.getElementById('logoutDialog').classList.add('active');
    }

    function hideLogoutDialog() {
        document.getElementById('logoutDialog').classList.remove('active');
    }

    function logout() {
        $.post("includes/handlers/ajax/logoutJson.php", function () {
            location.reload();
        });
    }

    // Close dialog when clicking outside
    document.getElementById('logoutDialog').addEventListener('click', function (e) {
        if (e.target === this) {
            hideLogoutDialog();
        }
    });
</script>