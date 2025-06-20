function showMsg(msg) {
    let statusMsg = document.getElementById('status-msg');
    statusMsg.textContent = msg;
    statusMsg.classList.remove('success');
    statusMsg.classList.add('error');
}

function validateProductForm(product_id) {
    let name = document.getElementById('name').value;
    let category = document.getElementById('category_id').value;
    let price = document.getElementById('price').value;
    let stock = document.getElementById('stock').value;
    let desc = document.getElementById('description').value;
    let image = document.getElementById('image_url').value;

    if (name.length < 2 || name.length > 120) {
        showMsg("Naziv mora imati bar 2 slova");
        return false;
    }

    if (!category) {
        showMsg("Izaberite kategoriju.");
        return false;
    }

    if (price === "" || isNaN(price) || Number(price) < 0) {
        showMsg("Cijena mora biti broj veci od 0");
        return false;
    }

    if (stock === "" || isNaN(stock) || Number(stock) < 0) {
        showMsg("Kolicina mora biti broj veci od 0");
        return false;
    }

    if (desc.length > 250) {
        showMsg("Opis moze imati najvise 250 karaktera");
        return false;
    }

    if (image.length > 255) {
        showMsg("URL slike je predugačak.");
        return false;
    }
    fetchData(product_id)
    return true;
}

function fetchData(product_id) {

    let name = document.getElementById('name').value;
    let category_id = document.getElementById('category_id').value;
    let price = document.getElementById('price').value;
    let stock = document.getElementById('stock').value;
    let description = document.getElementById('description').value;
    let image_url = document.getElementById('image_url').value;
    let ajax = 1;

    $.ajax({
        type: 'POST',
        url: 'edit_product.php?id=' + product_id,
        data: {
            name: name,
            category_id: category_id,
            price: price,
            stock: stock,
            description: description,
            image_url: image_url,
            ajax: ajax
        },
        success: function(resp) {
            if (resp.trim() === 'OK') {
                alert('Proizvod je uspešno izmenjen!');
                window.location.href = 'adminpanel.php';
            } else {
                showMsg(resp);
            }
        },
        error: function() {
            showMsg('Greška u komunikaciji sa serverom!');
        }
    });
}