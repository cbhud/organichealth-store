function showMsg(msg, success) {
    let statusMsg = document.getElementById('product-msg');
    statusMsg.textContent = msg;
    statusMsg.classList.remove('success', 'error');
    if (success) {
        statusMsg.classList.add('success');
    } else {
        statusMsg.classList.add('error');
    }
}

function validateProductForm() {
    let name = document.getElementById('name').value.trim();
    let category = document.getElementById('category_id').value;
    let price = document.getElementById('price').value.trim();
    let stock = document.getElementById('stock').value.trim();
    let desc = document.getElementById('description').value.trim();
    let image = document.getElementById('image_url').value.trim();

    if (name.length < 2 || name.length > 120) {
        showMsg("Naziv mora imati od 2 do 120 karaktera.");
        return false;
    }
    if (!category) {
        showMsg("Izaberite kategoriju.");
        return false;
    }
    if (price === "" || isNaN(price) || Number(price) < 0 || Number(price) > 10000) {
        showMsg("Cena mora biti broj od 0 do 10000.");
        return false;
    }
    if (stock === "" || isNaN(stock) || Number(stock) < 0 || Number(stock) > 100000) {
        showMsg("Na stanju mora biti broj od 0 do 100000.");
        return false;
    }
    if (desc.length < 5 || desc.length > 800) {
        showMsg("Opis mora imati od 5 do 800 karaktera.");
        return false;
    }
    if (image.length > 300) {
        showMsg("URL slike je predugačak.");
        return false;
    }
    fetchData();
    return true;
}

function fetchData(){

    let name = document.getElementById('name').value.trim();
    let category_id = document.getElementById('category_id').value;
    let price = document.getElementById('price').value.trim();
    let stock = document.getElementById('stock').value.trim();
    let description = document.getElementById('description').value.trim();
    let image_url = document.getElementById('image_url').value.trim();

    $.ajax({
        type: 'POST',
        url: 'create_product.php',
        data: {
            name: name,
            category_id: category_id,
            price: price,
            stock: stock,
            description: description,
            image_url: image_url,
            ajax: 1
        },
        success: function(response) {
            if (response.trim() === "OK") {
                showMsg("Proizvod je uspešno kreiran!", true);
                document.getElementById('create-product').reset();
            } else {
                showMsg(response);
            }
        },
        error: function() {
            showMsg("Greška u komunikaciji sa serverom!");
        }
    });
}