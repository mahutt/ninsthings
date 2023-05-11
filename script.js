// QUANTITY-SELECT FUNCTIONALITY
function step(anchor, stepDirection) {
    const quantity = anchor.parentNode.querySelector('.quantity-number');
    if (stepDirection < 0 && quantity.value > 1) {
        quantity.value--;
    }
    else if (stepDirection > 0 && quantity.value < parseInt(quantity.max)) {
        quantity.value++;
    } 
    // alert(quantity.max);
}

// SIZE-SELECT
function selected(label) {
    const labelWrapper = label.parentNode;
    if (labelWrapper.classList.contains("invalid-size")) {
        labelWrapper.classList.remove("invalid-size");
        labelWrapper.offsetWidth;
    }
    const labels = labelWrapper.querySelectorAll('label');
    for (var i = 0; i < labels.length; i++) {
        if (labels[i].classList.contains("selected-size"))
            labels[i].classList.remove("selected-size");
    }
    label.classList.add("selected-size"); // HIGHLIGHTING THE SELECTED LABEL
    const notice = label.parentNode.parentNode.querySelector(".quantity-notice");
    notice.innerHTML = label.id + "&nbspleft"; // DISPLAYING REMAINING QUANTITY FOR SELECTED SIZE
    const quantity = notice.parentNode.querySelector(".product-quantity").querySelector(".quantity-number");
    quantity.max = label.id;
    if (quantity.value > quantity.max) {
        quantity.value = quantity.max;
    }
}

// VALIDATE FORM WHEN 'ADDING TO CART'
function validateCartForm(form) {
    const radios = form.querySelectorAll(".size-radio");
    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            displaySpinner();
            return true;
        }
    }
    const radiobox = form.querySelector(".product-size");
    if (radiobox.classList.contains("invalid-size")) {
        radiobox.classList.remove("invalid-size");
        radiobox.offsetWidth;
    }
    radiobox.classList.add("invalid-size");
    return false;
}

// DISPLAYING SPINNER WHEN ATTEMPTING REDIRECT
function displaySpinner() {
    document.querySelector('.spinner-wrapper').style.display = 'flex';
}

// Sliding to the next/previous image
function slide(button, direction) {
    const slider = button.parentNode.parentNode.querySelector('.slider');
    slider.scrollLeft += slider.offsetWidth * direction;
    if (direction < 0) {
        if (button.classList.contains('slideLeft')) {
            button.classList.remove('slideLeft');
            button.offsetWidth;
        } 
        button.classList.add('slideLeft');
    } else if (direction > 0) {
        if (button.classList.contains('slideRight')) {
            button.classList.remove('slideRight');
            button.offsetWidth;
        }
        button.classList.add('slideRight');
    } 
}

// APPLYING SLIDE TO SLIDER BUTTONS
const sliderButtons = document.querySelectorAll('.slider-buttons');
for (let i = 0; i < sliderButtons.length; i++) {
    sliderButtons[i].children[0].addEventListener('click', function() {
        slide(this, -1);
    });
    sliderButtons[i].children[1].addEventListener('click', function() {
        slide(this, 1);
    });
}

// APPLYING DISPLAY-SPINNER ONCLICK TO ALL RELEVANT ANCHOR TAGS / SUBMIT BUTTONS
const redirects = document.querySelectorAll('.redirect');
for (let i = 0; i < redirects.length; i++) {
    redirects[i].onclick = function() {
        displaySpinner();
    };
}

// APPLYING THE selected() FUNCTION TO ALL LABELS
const sizeLabels = document.querySelectorAll(".size-label");
for (let i = 0; i < sizeLabels.length; i++) {
    sizeLabels[i].addEventListener('click', function() {
        selected(this);
    });
}

// APPLYING UNDERLINE UNDER ACTIVE NAV ITEM
const url = window.location.href;
const navitems = document.querySelectorAll(".nav-item");
for (let i = 0; i < navitems.length; i++) {
    if (navitems[i].href == url) {
        navitems[i].parentNode.innerHTML += "<span class=\"underline\"></span>";
        break;
    }
}

// ANIMATING HEADER ON HOVER
function giggle(letters, n) {
    if (n < letters.length) {
        if (letters[n].classList.contains('giggle')) {
            letters[n].classList.remove('giggle');
            letters[n].offsetWidth;
        }
        letters[n].classList.add('giggle');
        setTimeout(() => {
            giggle(letters, n + 1);
        }, 30);
    } else {
        console.log("End");
    }
}
const heading = document.querySelector(".heading");
const letters = heading.innerHTML.split('');
let wrappedLetters = "";
for (const letter of letters) {
    wrappedLetters += (letter == " " ? ('<span>&nbsp</span>') : ('<span>' + letter + '</span>'));
}
heading.innerHTML = wrappedLetters;
heading.addEventListener('click', function() {
    giggle(this.children, 0);
});
window.onload = () => {
    setTimeout(() => {
        giggle(heading.children, 0); // RUNNING GIGGLE ON LOAD
    }, 500)
}








