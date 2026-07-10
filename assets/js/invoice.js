





// Get Chalan Number

$("#p_name").change(function () {

    var p_name = $(this).val();

    $.ajax({

        url: "data/get_bill.php",
        type: "POST",
        data: {
            p_name: p_name
        },
        success: function (data) {
            $("#Chalan_no").html(data);
        }

    });

});

$("#chalan_no").change(function () {
    $.ajax({

        url: "data/get_bill.php",
        type: "POST",
        data: {
            p_name: $("p_name").val()
        },
        success: function (data) {
            $("#Chalan_no").html(data);
            $("#chalanNo").modal("show");
        }

    });

});




// Get party name select data show


$(document).ready(function () {

    // load dropdown
    $.ajax({
        url: "data/party_data.php",
        method: "GET",
        success: function (data) {
            $("#p_name").append(data);
        }
    });

});


$("#p_name").on("change", function () {

    let p_Name = $(this).val();

    if (p_Name !== "") {

        $.ajax({
            url: "data/get_user.php",
            method: "POST",
            data: {
                p_name: p_Name
            },
            dataType: "json",
            success: function (res) {
                $("#party_id").val(res.party_id);
                $("#gst").val(res.gst);
                $("#p_address").val(res.p_address);
            }
        });

    }

});



// Get design_no_1 design_no_2 dropdown data

$("#p_name").change(function () {

    var p_name = $(this).val();

    $.ajax({

        url: "data/get_chalan.php",
        type: "POST",
        data: {
            p_name: p_name
        },
        success: function (data) {
            $("#design_no_1").html(data);
            $(".design_no_2").html(data);
        }

    });

});


$(document).ready(function () {

    // load dropdown
    $.ajax({
        url: "data/invoice_data.php",
        method: "GET",
        success: function (data) {
            $("#design_no_1").append(data);
            $("#design_no_2").append(data);
        }
    });

});


$("#design_no_1").on("change", function () {

    let Design_no = $(this).val();

    if (Design_no !== "") {
        $.ajax({
            url: "data/get_order.php",
            method: "POST",
            data: {
                design_no: Design_no
            },
            dataType: "json",
            success: function (go) {
                $("#cut_1").val(go.cut);
                $("#total_metre_1").val(go.total_metre);
                $("#rate_1").val(go.rate);
                $("#amount_1").val(go.amount);
                if (typeof calculateChalanTotal === "function") {
                    calculateChalanTotal();
                }
            }
        });

    } else {
        $("#cut_1").val(""); // Clear all input fields
        $("#total_metre_1").val(""); // Clear all input fields
        $("#rate_1").val(""); // Clear all input fields
        $("#amount_1").val(""); // Clear all input fields
        return;

    }

});


$("#design_no_2").on("change", function () {

    let Design_no = $(this).val();

    if (Design_no !== "") {
        $.ajax({
            url: "data/get_order.php",
            method: "POST",
            data: {
                design_no: Design_no
            },
            dataType: "json",
            success: function (go) {
                $("#cut_2").val(go.cut);
                $("#total_metre_2").val(go.total_metre);
                $("#rate_2").val(go.rate);
                $("#amount_2").val(go.amount);
                if (typeof calculateChalanTotal === "function") {
                    calculateChalanTotal();
                }
            }
        });

    } else {
        $("#cut_2").val(""); // Clear all input fields
        $("#total_metre_2").val(""); // Clear all input fields
        $("#rate_2").val(""); // Clear all input fields
        $("#amount_2").val(""); // Clear all input fields
        return;

    }

});




// New row add in invoice


function updateCount() {

    let total = document.querySelectorAll(".col-remove").length;

    document.getElementById("totalRow").value = total;
}

document.getElementById("addRow").onclick = function () {

    let row = document.createElement("div");

    row.className = "row";

    row.innerHTML =
        `<div class="col-4 mb-3 col-remove">
                    <label class="form-label">Maching No.</label>
                    <input type="text" name="matching_no[]" class="form-control" placeholder="Maching no">
                </div>

                <div class="col-4 mb-3">
                    <label class="form-label">Cut</label>
                    <input type="text" name="cut[]" class="form-control cut" placeholder="Cut">
                </div>

                <div class="col-4 mb-3 align-self-center removeBtn">
                     Remove
                    <span class="nav-icon">
                        <iconify-icon icon="mingcute:close-line"></iconify-icon>
                    </span>
                </div>`;


    document.getElementById("invoiceForm").appendChild(row);

    updateCount();
};


document.addEventListener("click", function (e) {

    if (e.target.classList.contains("removeBtn")) {

        e.target.parentElement.remove();

        updateCount();
    }

});




// Chalan no and amount New row add

document.getElementById("addRow").onclick = function () {

    let row = document.createElement("div");

    row.className = "row";

    row.innerHTML =
        `<div class="col-4 mb-3 col-remove">
            <label class="form-label">Chalan No.</label>
            <input type="text" name="chalan_no[]" class="form-control" placeholder="Chalan no">
        </div>

        <div class="col-4 mb-3">
            <label class="form-label">Chalan Amount</label>
            <input type="text" name="c_amount[]" class="form-control c_amount" placeholder="Chalan amount">
        </div>

        <div class="col-4 mb-3 align-self-center c_removeBtn">
                     Remove
            <span class="nav-icon">
                <iconify-icon icon="mingcute:close-line"></iconify-icon>
            </span>
    </div>`;


    document.getElementById("BillForm").appendChild(row);

    updateCount();
};


document.addEventListener("click", function (e) {

    if (e.target.classList.contains("c_removeBtn")) {

        e.target.parentElement.remove();

        updateCount();
    }

});








// cut Change invoice
document.addEventListener("keyup", function (e) {

    if (e.target.classList.contains("cut")) {
        calculateTotalMetre();
    }

});

// document.addEventListener("change", function (e) {

//     if (e.target.classList.contains("cut")) {
//         totalcut();
//     }

// });


// Total Function invoice (fixed recursion and renamed)
function calculateTotalMetre() {
    let cutInputs = document.querySelectorAll(".cut");
    let total = 0;
    cutInputs.forEach(function (input) {
        let cut = parseFloat(input.value) || 0;
        total += cut;
    });
    let totalMetreEl = document.getElementById("total_metre");
    if (totalMetreEl) {
        totalMetreEl.value = total;
        // recalculate order amount
        calculateOrderAmount();
    }
}




// total price invoice (renamed and safe)
function calculateOrderAmount() {
    let qtyEl = document.getElementById("total_metre");
    let priceEl = document.getElementById("rate");
    let amountEl = document.getElementById("amount");
    if (qtyEl && priceEl && amountEl) {
        let qty = parseFloat(qtyEl.value) || 0;
        let price = parseFloat(priceEl.value) || 0;
        amountEl.value = (qty * price).toFixed(2).replace(/\.00$/, '');
    }
}

// Auto calculate on typing
// document.getElementById("total_metre").addEventListener("input", calculateTotal);
let rateEl = document.getElementById("rate");
if (rateEl) {
    rateEl.addEventListener("input", calculateOrderAmount);
}
// document.getElementById("pay_amount").addEventListener("input", calculateTotal);



















// Chalan amount total Change

document.addEventListener("keyup", function (e) {

    if (e.target.classList.contains("c_amount")) {
        calculateTotalMetre();
    }

});



// Total Function invoice (renamed and fixed recursion)
function calculateTotalChalanAmount() {
    let cutInputs = document.querySelectorAll(".c_amount");
    let total = 0;
    cutInputs.forEach(function (input) {
        let cut = parseFloat(input.value) || 0;
        total += cut;
    });
    let totalCAmountEl = document.getElementById("total_c_amount");
    if (totalCAmountEl) {
        totalCAmountEl.value = total;
        // Triggers bill discount calculations
        if (typeof calculateDiscount === "function") {
            calculateDiscount();
        }
    }
}




// Discount Value Calculation

//  function customRoundDesimal(value) {
//     let integer = Math.floor(value);
//     let decimal = value - integer;

//     if (decimal >= .5) {
//         return (integer + 1);
//     } 
// }

$(document).ready(function () {

    function calculateDiscount() {
        var total_c_amount = parseFloat($("#total_c_amount").val()) || 0;
        var dis_rate = parseFloat($("#dis_rate").val()) || 0;
        var paid_amount = parseFloat($("#paid_amount").val()) || 0;

        var discountAmount = (total_c_amount * dis_rate) / 100;
        var finalAmount = total_c_amount - discountAmount;
        var c_s_gst_Amount = finalAmount * 2.5 / 100;
        var total_gst_Amount = c_s_gst_Amount + c_s_gst_Amount;
        var total_Amount = finalAmount + total_gst_Amount;

        $("#dis_amount").val(discountAmount);
        $("#cgst").val(c_s_gst_Amount.toFixed(2));
        $("#sgst").val(c_s_gst_Amount.toFixed(2));
        $("#totalgst").val(total_gst_Amount.toFixed(2));
        $("#final_amount").val( Math.round(total_Amount));
        calculateBillPending();
    }

    $(".dis_amount, #dis_rate").on("click change", function () {
        calculateDiscount();
    });

});

// pending Value Calculation

// total price invoice (renamed and safe)
function calculateBillPending() {
    let finalEl = document.getElementById("final_amount");
    let paidEl = document.getElementById("paid_amount");
    let pendingEl = document.getElementById("pending_amount");
    if (finalEl && paidEl && pendingEl) {
        let final_amount = parseFloat(finalEl.value) || 0;
        let pay_a = parseFloat(paidEl.value) || 0;
        pendingEl.value = (final_amount - pay_a).toFixed(2).replace(/\.00$/, '');
    }
}

// Auto calculate on typing
let paidAmtEl = document.getElementById("paid_amount");
if (paidAmtEl) {
    paidAmtEl.addEventListener("input", calculateBillPending);
}






















// total price invoice

// function customRound(value) {
//     let integer = Math.floor(value);
//     let decimal = value - integer;

//     if (decimal >= 0.01 && decimal <= 0.49) {
//         return (integer + 0.50).toFixed(2);
//     } else if (decimal >= 0.51 && decimal <= 0.74) {
//         return (integer + 0.75).toFixed(2);
//     } else if (decimal >= 0.76) {
//         return (integer + 1).toFixed(2);
//     } else {
//         return value.toFixed(2); // For .00, .50, .75, etc.
//     }
// }


// $(".rate").on("input", function () {
//     let total_c_amount = parseFloat($(".total_c_amount").val()) || 0;
//     let rate = parseFloat($(".rate").val()) || 0;

//     let amount = total_c_amount / rate;

//     $(".c_qty").val(customRound(amount));
    
// });



// $(".b_total_amount").on("click", function () {
//     let rate = parseFloat($(".rate").val()) || 0;
//     let qty = parseFloat($(".c_qty").val()) || 0;

//     $(".b_total_amount").val((rate * qty).toFixed(2));
// });





