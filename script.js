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
    const labels = label.parentNode.querySelectorAll('label');
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

// APPLYING THE selected() FUNCTION TO ALL LABELS
const sizeLabels = document.querySelectorAll(".size-label");
for (var i = 0; i < sizeLabels.length; i++) {
    sizeLabels[i].addEventListener('click', function() {
        selected(this);
    });
}

// APPLYING UNDERLINE UNDER ACTIVE NAV ITEM
console.log("HI");
const url = window.location.href;
const navitems = document.querySelectorAll(".nav-item");
for (let i = 0; i < navitems.length; i++) {
    console.log(navitems[i].href);
    if (navitems[i].href == url) {
        navitems[i].parentNode.innerHTML += "<span class=\"underline\"></span>";
        break;
    }
}