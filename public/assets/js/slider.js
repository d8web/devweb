// Slider

let currentSlide = 0;
let totalSlides = document.querySelectorAll(".slider-item").length
document.querySelector(".slider-width").style.width = `calc(100vw * ${totalSlides})`
document.querySelector(".slider-controls").style.height = `${document.querySelector(".slider").clientHeight}px`

const goPrev = () => {
    currentSlide--;
    if(currentSlide < 0) {
        currentSlide = totalSlides - 1
    }
    updateMargin();
}

const goNext = () => {
    currentSlide++;
    if(currentSlide > (totalSlides - 1)) {
        currentSlide = 0;
    }
    updateMargin();
}

const updateMargin = () => {
    let sliderItemWidth = document.querySelector(".slider-item").clientWidth
    let newMargin = (currentSlide * sliderItemWidth)
    document.querySelector(".slider-width").style.marginLeft = `-${newMargin}px`
}

// Automatic next slider
// setInterval(goNext, 5000);

// const showAndHideSuccessMessageEmail = () => {
//     let messageDiv = document.querySelector(".message")
//     if(messageDiv !== null) {
//         setInterval(() => {
//             messageDiv.style.top = `-${500}px`
//             messageDiv.style.display = 0
//         }, 6000 * 2)
//     }
// }

// const showAndHideErrorMessageEmail = () => {
//     let messageDiv = document.querySelector(".error")
//     if(messageDiv !== null) {
//         setInterval(() => {
//             messageDiv.style.top = `-${500}px`
//             messageDiv.style.display = 0
//         }, 6000 * 2)
//     }
// }

// showAndHideSuccessMessageEmail();
// showAndHideErrorMessageEmail();