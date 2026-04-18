function getId() {
    let url = window.location.search;
    let params = new URLSearchParams(url);
    return params.get('id');
}

const ORDER_ID = getId();

function showStatus(msg, isSuccess = true) {
    let orderMsg = document.getElementById("order-msg");
    if (!orderMsg) return;
    orderMsg.textContent = msg;
    orderMsg.style.color = isSuccess ? "#197b30" : "#d9534f";
}

function validateAddress() {
    let address = document.getElementById("address").value.trim();
    let span = document.getElementById("addressErr");
    if (address.length < 6) {
        span.textContent = "Adresa prekratka";
        span.style.color = "red";
        return false;
    }
    span.textContent = "";
    return true;
}

function validateCity() {
    let city = document.getElementById("city").value.trim();
    let span = document.getElementById("cityErr");
    if (city.length < 2) {
        span.textContent = "Grad nije validan";
        span.style.color = "red";
        return false;
    }
    span.textContent = "";
    return true;
}

function validateNote() {
    let note = document.getElementById("note").value;
    let span = document.getElementById("noteErr");
    if (note.length > 300) {
        span.textContent = "Napomena predugačka";
        span.style.color = "red";
        return false;
    }
    span.textContent = "";
    return true;
}

function removeOrderItem(btn) {
    if (!confirm('Da li ste sigurni da želite da uklonite ovu stavku iz narudžbine?')) return;
    let row = btn.closest('tr');
    let orderItemId = btn.getAttribute('data-order-item-id');
    $.ajax({
        type: "POST",
        url: "utils/update_order.php",
        data: {
            action: "remove_item",
            order_id: ORDER_ID,
            order_item_id: orderItemId
        },
        success: function(response) {
            if (response === "OK") {
                row.parentNode.removeChild(row);
                updateOrderTotal();
            } else {
                alert("Greška: " + response);
            }
        }
    });
}

function updateOrderTotal() {
    let total = 0;
    let rows = document.querySelectorAll('.order-items-table tbody tr');
    rows.forEach(function(row) {
        let cell = row.querySelectorAll('td')[3];
        if (!cell) return;
        let value = parseFloat(cell.textContent.replace('€','').trim());
        if (!isNaN(value)) total += value;
    });
    document.getElementById("order-total").textContent = total;
}

function saveOrder() {
    let validAddress = validateAddress();
    let validCity = validateCity();
    let validNote = validateNote();

    if (validAddress && validCity && validNote) {
        let address = document.getElementById('address').value.trim();
        let city = document.getElementById('city').value.trim();
        let note = document.getElementById('note').value.trim();
        let adminStatusInput = document.getElementById("order-status-admin");
        if (adminStatusInput == null) {
            let adminStatusInput = '';
        }else {
            adminStatusInput = document.getElementById("order-status-admin").value;
        }

        $.ajax({
            type: "POST",
            url: "utils/update_order.php",
            data: {
                action: "save_order",
                order_id: ORDER_ID,
                address: address,
                city: city,
                note: note,
                status: adminStatusInput
            },
            success: function(response) {
                if (response === "OK") {
                    showStatus("Narudžbina uspešno sačuvana!");
                    setTimeout(() => window.location.href = "admin/adminpanel.php", 1000);
                } else {
                    showStatus("Greška: " + response, false);
                }
            }
        });
    } else {
        showStatus("Nisu ispravni svi podaci", false);
    }
}

function cancelOrder() {
    if (!confirm('Da li ste sigurni da želite da otkažete ovu narudžbinu?')) return;
    $.ajax({
        type: "POST",
        url: "utils/update_order.php",
        data: {
            action: "cancel_order",
            order_id: ORDER_ID
        },
        success: function(response) {
            if (response === "OK") {
                showStatus("Narudžbina je uspešno otkazana!", true);
                setTimeout(() => location.reload(), 1000);
            } else {
                showStatus("Greška: " + response, false);
            }
        }
    });
}
