function showCartPopup2() {
    let background = document.createElement("div");
    background.id = "cart-popup-overlay";
    background.className = "cart-popup-overlay";

    let popup = document.createElement("div");
    popup.className = "cart-popup-modal";

    popup.innerHTML = `
  <img src="https://cliply.co/wp-content/uploads/2021/03/372103860_CHECK_MARK_400px.gif"
       alt="success" style="width:90px;display:block;margin:0 auto 16px auto;" />
  <p>Narudzbina uspjesno poslata!</p>
  <div class="cart-popup-actions">
    <a href="/web-shop/index.php" class="btn">Nazad na pocetnu</a>
  </div>
`;


    background.appendChild(popup);

    document.body.appendChild(background);

}