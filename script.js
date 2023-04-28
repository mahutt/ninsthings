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
    label.classList.add("selected-size");     
}

// APPLYING THE selected() FUNCTION TO ALL LABELS
const sizeLabels = document.querySelectorAll(".size-label");
for (var i = 0; i < sizeLabels.length; i++) {
    sizeLabels[i].addEventListener('click', function() {
        selected(this);
    });
}



// MARK OFF SIZE LABEL IF IT IS THE ONLY SIZE AVAILABLE

