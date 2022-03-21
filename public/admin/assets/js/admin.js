const toogleMenuAdmin = () => {

    let btnMenuAdmin = document.querySelector("header i")   

    btnMenuAdmin.addEventListener("click", (e) => {
        let asideMenu = document.querySelector(".menu-lateral")
        asideMenu.classList.toggle("left")
        if(asideMenu.classList.contains("left")) {
            btnMenuAdmin.classList.remove("fa-bars")
            btnMenuAdmin.classList.add("fa-times")

            document.querySelector("header i").style.transition = "all .5s ease-in-out"
            let bodyWidth = document.body.clientWidth
            
            if(bodyWidth >= 580) {
                document.querySelector("header i").style.marginLeft = "175px"
            } else {
                document.querySelector("header i").style.marginLeft = "255px"
            }
        } else {
            btnMenuAdmin.classList.remove("fa-times")
            btnMenuAdmin.classList.add("fa-bars")
            document.querySelector("header i").style.marginLeft = 0
        }
    })

}

toogleMenuAdmin();