function changeImage(direction) {
    index = document.getElementById("imageIndex");
    index.innerHTML = ((index.innerHTML + direction) % 3);
    image = document.getElementById("product-image");
    image.src = image.src.replace(/\d+\.jpg$/, index.innerHTML + ".jpg");
    // console.log(index.innerHTML);
}