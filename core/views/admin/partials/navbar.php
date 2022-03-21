<header class="p-20 d-flex flex-between">
    <i class="fa fa-bars"></i>
    <nav>
        <ul class="d-flex">
            <li><input type="checkbox" name="mode" id="mode"></li>
            <li class="mobile-none">
                <?=isset($loggedAdmin->name) ? $loggedAdmin->name : "Admin";?>
            </li>
            <li class="mobile-none">
                <a href="<?=BASE_URL?>admin/logout">Sair</a>
            </li>
        </ul>
    </nav>
</header>

<script>
    let darkMode = localStorage.getItem("dark")
    const checkButton = document.getElementById("mode")

    const enableDarkMode = () => {
        document.body.classList.add("dark")
        localStorage.setItem("dark", "enabled")
    }

    const disabledDarkMode = () => {
        document.body.classList.remove("dark")
        localStorage.setItem("dark", null)
    }

    if(darkMode === "enabled") {
        enableDarkMode()
        let check = document.getElementById("mode")
        check.checked = true
    }

    checkButton.addEventListener("click", () => {
        darkMode = localStorage.getItem("dark")
        if(darkMode !== "enabled") {
            enableDarkMode()
        } else {
            disabledDarkMode()
        }
    })
</script>