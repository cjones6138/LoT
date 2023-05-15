// Event listener to ensure html page is loaded before javascript functions
if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready);
} else {
    ready();
}

// Event listeners active once page has fully loaded
function ready() {
    
    var removeCartItemButtons = document.getElementsByClassName('btnDanger');
    for (var i = 0; i < removeCartItemButtons.length; i++) {
        var button = removeCartItemButtons[i];
        button.addEventListener('click', removeCartItem);
    }

    var addToCartButtons = document.getElementsByClassName('shopItemButton');
    for (var i = 0; i < addToCartButtons.length; i++) {
        var button = addToCartButtons[i];
        button.addEventListener('click', addToCartClicked);
    }

    document.getElementsByClassName('btnPurchase')[0].addEventListener('click', purchaseClicked);
}

// Clear cart on click of 'Purchase' button
function purchaseClicked() {
    var cartItems = document.getElementsByClassName('cartItems')[0];
    while (cartItems.hasChildNodes()) {
        cartItems.removeChild(cartItems.firstChild);
    }
    updateCartTotal();
}

// Remove item from cart on 'Remove' button click
// Called from function ready var removeCartItemButtons
// Calls fucntion updateCartTotal
function removeCartItem(event) {
    var buttonClicked = event.target;
    var cartRow = buttonClicked.parentElement.parentElement;
    var title = cartRow.getElementsByClassName('cartItemTitle')[0].innerText;
    var xhttp = new XMLHttpRequest();
    
    switch (title) {
        case "Chains of Ultimatum":
            xhttp.open("GET", "mysql_connection.php?functionToCall=removeChains", true);
            xhttp.send();
            break;
        case "Staff of Eternity":
            xhttp.open("GET", "mysql_connection.php?functionToCall=removeStaff", true);
            xhttp.send();
            break;
        case "Swords of Fission":
            xhttp.open("GET", "mysql_connection.php?functionToCall=removeSwords", true);
            xhttp.send();
            break;
        case "Dark Matter Daggers":
            xhttp.open("GET", "mysql_connection.php?functionToCall=removeDaggers", true);
            xhttp.send();
            break;
        default:
            break;
    }
    buttonClicked.parentElement.parentElement.remove();
    updateCartTotal();
}

// Add items to cart and to database
// Called from fucntion ready var addToCartButtons
// Calls fuction addItemToCart, function updateCartTotal
function addToCartClicked(event) {

    var button = event.target;
    var shopItem = button.parentElement.parentElement.parentElement;
    var title = shopItem.getElementsByClassName('shopItemTitle')[0].innerText;
    var price = shopItem.getElementsByClassName('shopItemPrice')[0].innerText;
    var imageSrc = shopItem.getElementsByClassName('shopItemImage')[0].src;
    addItemToCart(title, price, imageSrc);
    updateCartTotal();
    
}

// Check for item in cart and add item if needed
// Called from function addToCartClicked
function addItemToCart(title, price, imageSrc) {
    var cartRow = document.createElement('div');
    cartRow.classList.add('cartRow');
    var cartItems = document.getElementsByClassName('cartItems')[0];
    var cartItemNames = cartItems.getElementsByClassName('cartItemTitle');
    for (var i = 0; i < cartItemNames.length; i++) {
        if (cartItemNames[i].innerText == title) {
            alert('Item has already been added to your cart.');
            return;
        }
    }
    var cartRowContents = `
        <div class="cartItem cartColumn">
            <img class="cartItemImage" src="${imageSrc}" width="100" height="100">
            <span class="cartItemTitle">${title}</span>
        </div>
        <span class="cartPrice cartColumn">${price}</span>
        <div class="cartRemove cartColumn">
            <button class="btn btnDanger" type="button">REMOVE</button>
        </div>`;
    cartRow.innerHTML = cartRowContents;
    cartItems.append(cartRow);
    cartRow.getElementsByClassName('btnDanger')[0].addEventListener('click', removeCartItem);
    var xhttp = new XMLHttpRequest();
    
    switch (title) {
        case "Chains of Ultimatum":
            xhttp.open("GET", "mysql_connection.php?functionToCall=insertChains", true);
            xhttp.send();
            break;
        case "Staff of Eternity":
            xhttp.open("GET", "mysql_connection.php?functionToCall=insertStaff", true);
            xhttp.send();
            break;
        case "Swords of Fission":
            xhttp.open("GET", "mysql_connection.php?functionToCall=insertSwords", true);
            xhttp.send();
            break;
        case "Dark Matter Daggers":
            xhttp.open("GET", "mysql_connection.php?functionToCall=insertDaggers", true);
            xhttp.send();
            break;
        default:
            break;
    }
}

// Update total cost of cart items on webpage
// Called from function addToCartClicked
function updateCartTotal() {
    var cartItemContainer = document.getElementsByClassName('cartItems')[0];
    var cartRows = cartItemContainer.getElementsByClassName('cartRow');
    var total = 0;
    for (var i = 0; i < cartRows.length; i++) {
        var cartRow = cartRows[i];
        var priceElement = cartRow.getElementsByClassName('cartPrice')[0];
        var price = parseFloat(priceElement.innerText.replace('$', ''));
        total = total + price;
    }
    total = Math.round(total * 100) / 100;
    document.getElementsByClassName('cartTotalPrice')[0].innerText = '$' + total;
}