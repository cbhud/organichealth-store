function showCartPopup() {
    let background = document.createElement("div");
    background.id = "cart-popup-overlay";
    background.className = "cart-popup-overlay";

    let popup = document.createElement("div");
    popup.className = "cart-popup-modal";

    popup.innerHTML = `
    <img src="https://cliply.co/wp-content/uploads/2021/03/372103860_CHECK_MARK_400px.gif"
         alt="success" style="width:90px;display:block;margin:0 auto 16px auto;" />
    <p>Proizvod je dodat u korpu!</p>
    <div class="cart-popup-actions">
      <a href="cart.php" class="btn">Idi u korpu</a>
      <button class="btn" id="close-cart-popup">Nastavi kupovinu</button>
    </div>
  `;

    background.appendChild(popup);

    document.body.appendChild(background);

    document.getElementById("close-cart-popup").onclick = () => {
        background.remove();
    };

    background.onclick = (event) => {
        if (event.target === background) {
            background.remove();
        }
    };
}