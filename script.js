
// const image = document.getElementById('movable-image');

// const randomPosition = () => {

//     const viewportWidth = window.innerWidth;
//     const viewportHeight = window.innerHeight;
//     const randomX = Math.random() * (viewportWidth - image.width);
//     const randomY = Math.random() * (viewportHeight - image.height);


//     image.style.left = `${randomX}px`;
//     image.style.top = `${randomY}px`;
// };


// image.addEventListener('mouseover', randomPosition);

const redirect_after_one_sec = () => {
    setTimeout(() => {
        window.location.href = "index.php"; 
    }, 1000);
}


function showthebeer_waitasec_andgo (addr) {

document.getElementById ("beer").style.display = "inline";

setTimeout(() => {
    window.location.href = addr; 
}, 880);
}



