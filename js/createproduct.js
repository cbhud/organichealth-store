document.addEventListener('DOMContentLoaded', function() {
    let imageInput = document.getElementById('image_url');
    let fileNameDisplay = document.getElementById('file-name');
    if (imageInput && fileNameDisplay) {
        imageInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = this.files[0].name;
            } else {
                fileNameDisplay.textContent = 'Izaberi sliku...';
            }
        });
    }
});

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
    let imageInput = document.getElementById('image_url');

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
    if (imageInput.files.length > 0) {
        let file = imageInput.files[0];
        if (file.size > 5 * 1024 * 1024) {
            showMsg("Slika ne sme biti veća od 5MB.");
            return false;
        }
        if (!file.type.match('image.*')) {
            showMsg("Fajl mora biti slika.");
            return false;
        }
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
    let imageInput = document.getElementById('image_url');

    let formData = new FormData();
    formData.append('name', name);
    formData.append('category_id', category_id);
    formData.append('price', price);
    formData.append('stock', stock);
    formData.append('description', description);
    formData.append('ajax', 1);

    let inRecommended = document.getElementById('inRecommended') && document.getElementById('inRecommended').checked ? '1' : '0';
    formData.append('inRecommended', inRecommended);

    if (imageInput.files.length > 0) {
        formData.append('image_url', imageInput.files[0]);
    }

    $.ajax({
        type: 'POST',
        url: 'create_product.php',
        data: formData,
        processData: false,
        contentType: false,
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