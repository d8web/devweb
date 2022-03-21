const scrollPage = () => {
    
    let menuDesktop = document.querySelectorAll(".desktop ul li a")
    let menuMobile = document.querySelectorAll(".mobile ul li a")

    const loopingMenu = (array) => {
        array.forEach(item => {
            item.addEventListener("click", (e) => {
                e.preventDefault();
    
                let textUrl = e.target.href;
                let textArray = textUrl.split("/");
                let lastItem = textArray[textArray.length - 1];
    
                switch(lastItem) {
                    case "public":
                    case "":
                        scrollToTop(item)                        
                    break;
                    case "about":
                    case "services":
                        scrollItem(lastItem)
                    break;
                    case "blog":
                    case "contact":
                        window.location.href = lastItem
                    break;
                }
    
            })
        })
    }

    loopingMenu(menuDesktop)
    loopingMenu(menuMobile)

    const scrollItem = (item) => {
        let target = document.getElementById(item);

        let textUrl = window.location.href;
        let textArray = textUrl.split("/");
        let lastItem = textArray[textArray.length - 1];

        const urlParams = new URLSearchParams(window.location.search);
        const myParam = urlParams.get("slug");

        if(lastItem === "contact" || lastItem === "blog" || myParam !== null) {
            window.location.href = BASE_URL;
            return;
        }
        
        if(target !== null) {
            target.scrollIntoView({
                behavior: "smooth"
            });
        }

    }

    const scrollToTop = (item) => {

        let textUrl = window.location.href;
        let textArray = textUrl.split("/");
        let lastItem = textArray[textArray.length - 1];

        const urlParams = new URLSearchParams(window.location.search);
        const myParam = urlParams.get("slug");

        if(lastItem === "contact" || lastItem === "blog" || myParam !== null) {
            window.location.href = item;
            return;
        }

        window.scrollTo(0, 0);

    }
}

scrollPage();