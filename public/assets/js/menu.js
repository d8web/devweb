const toogleMenu = () => {
    let btnMenu = document.querySelector(".mobile");
    
    btnMenu.addEventListener("click", (e) => {
        let listMenu = document.querySelector(".mobile ul");
        let btnMobileIcon = document.querySelector(".btn-mobile i");
    
        //console.log(btnMobileIcon)
        if(btnMobileIcon.classList.contains("fa-bars")) {
            btnMobileIcon.classList.remove("fa-bars");
            btnMobileIcon.classList.add("fa-times");
            document.querySelector("header").style.backgroundColor = "#0070f3"
        } else {
            btnMobileIcon.classList.remove("fa-times");
            btnMobileIcon.classList.add("fa-bars");
        }
        
        listMenu.classList.toggle("left");
        if(listMenu.classList.contains("left")) {
            document.body.style.overflowY = "hidden"
        } else {
            document.body.style.overflowY = "auto"
        }
    })
}

const ToogleShowHeaderBg = () => {
    let url = window.location.href
    let textArray = url.split("/");
    let lastItem = textArray[textArray.length - 1];

    if(lastItem !== "contact" && lastItem !== "blog") {
        window.addEventListener("scroll", () => {
            let top = document.documentElement.getBoundingClientRect().top;
            if(top < -50) {
                document.querySelector("header").style.backgroundColor = "#0070f3"
            } else {
                document.querySelector("header").style.backgroundColor = "transparent"
            }
        });
    } else {
        document.querySelector("header").style.backgroundColor = "#0070f3"
    }
}

ToogleShowHeaderBg();
toogleMenu();