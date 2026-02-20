function randomDeal() {
    const deals = [
        "50% off invisible keyboard!",
        "Buy 1 get 3 mysterious items!",
        "Free AI assistant (battery not included)."
    ];
    document.getElementById("deal").innerText =
        deals[Math.floor(Math.random() * deals.length)];
}

function addToCart(item) {
    document.getElementById("cart").innerText =
        item + " added to cart!";
}

function submitForm(event) {
    event.preventDefault();
    document.getElementById("formResponse").innerText =
        "Message sent! (not really)";
}

function fakeLogin(event) {
    event.preventDefault();
    document.getElementById("loginResponse").innerText =
        "Login successful! Welcome, valued beta tester.";
}