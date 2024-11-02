const redirect_after_one_sec = () => {
    setTimeout(() => {
        window.location.href = "index.php"; // Redirect to the specified URL
    }, 1000);
}

const image = document.getElementById('movable-image');

const randomPosition = () => {
    // Get viewport dimensions
    const viewportWidth = window.innerWidth;
    const viewportHeight = window.innerHeight;

    // Calculate random position, ensuring the image stays within the viewport
    const randomX = Math.random() * (viewportWidth - image.width);
    const randomY = Math.random() * (viewportHeight - image.height);

    // Set new position
    image.style.left = `${randomX}px`;
    image.style.top = `${randomY}px`;
};

// Add mouse over event listener to the image
image.addEventListener('mouseover', randomPosition);


const showthebeer_waitasec_andgo =(addr)=>{
//show the beer
document.getElementById ("beer").style.display = "inline";
//go somewhere
setTimeout(() => {
    window.location.href = addr; // Redirect to the specified URL
}, 880);
}