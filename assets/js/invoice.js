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


// ==================== CHALAN PAGE DYNAMIC LOGIC ====================
var cachedDesignOptions = '';

function loadChalanDesignOptions(p_name, callback) {
    $.ajax({
        url: "data/get_chalan.php",
        type: "POST",
        data: { p_name: p_name },
        success: function (data) {
            cachedDesignOptions = data;
            if (callback) callback(data);
        }
    });
}

// Party Name change on Chalan Page
$("#p_name").change(function () {
    if ($("#ChalanForm").length > 0) {
        var p_name = $(this).val();
        if (p_name) {
            loadChalanDesignOptions(p_name, function(options) {
                $(".card-select").each(function() {
                    $(this).html(options);
                    var row = $(this).closest('.design-row');
                    row.find('.cuts-container').empty();
                    row.find('.design-no-val, .design-matching-val, .design-metre, .design-rate, .design-amount, .design-cut-hidden').val('');
                });
                calculateChalanTotalAmount();
            });
        }
    }
});

// Load initial options for Chalan page (Edit Mode)
$(document).ready(function () {
    if ($("#ChalanForm").length > 0) {
        var initialParty = $("#p_name").val();
        if (initialParty) {
            loadChalanDesignOptions(initialParty);
        }
    }
});

// Add design row
$(document).on("click", "#addDesignRow", function() {
    var options = cachedDesignOptions || '<option value="">-- Select Card No --</option>';
    var newRow = $(
        '<div class="design-row border p-3 mb-3 bg-light rounded position-relative">' +
        '  <div class="row">' +
        '    <div class="col-md-2 col-12 mb-3">' +
        '      <label class="form-label font-weight-bold">Card No</label>' +
        '      <select class="form-select card-select" name="card_no[]" required>' +
        '        ' + options +
        '      </select>' +
        '    </div>' +
        '    <div class="col-md-2 col-6 mb-3">' +
        '      <label class="form-label font-weight-bold">Design No</label>' +
        '      <input type="text" name="design_no[]" class="form-control design-no-val" readonly>' +
        '    </div>' +
        '    <div class="col-md-2 col-6 mb-3">' +
        '      <label class="form-label font-weight-bold">Matching No</label>' +
        '      <input type="text" name="matching_no[]" class="form-control design-matching-val" readonly>' +
        '    </div>' +
        '    <div class="col-md-2 col-12 mb-3">' +
        '      <label class="form-label font-weight-bold">Cuts</label>' +
        '      <div class="cuts-section border p-2 rounded bg-white" style="min-height: 38px;">' +
        '        <div class="cuts-container d-flex flex-wrap gap-1 align-items-center mb-1">' +
        '        </div>' +
        '        <button type="button" class="btn btn-outline-secondary btn-xs add-cut-btn" style="padding: 2px 6px; font-size: 11px;">+ Add Cut</button>' +
        '      </div>' +
        '      <input type="hidden" name="cut[]" class="design-cut-hidden">' +
        '    </div>' +
        '    <div class="col-md-1 col-6 mb-3">' +
        '      <label class="form-label font-weight-bold">Total Metre</label>' +
        '      <input type="text" name="total_metre[]" class="form-control design-metre" readonly>' +
        '    </div>' +
        '    <div class="col-md-1 col-6 mb-3">' +
        '      <label class="form-label font-weight-bold">Rate</label>' +
        '      <input type="text" name="rate[]" class="form-control design-rate">' +
        '    </div>' +
        '    <div class="col-md-2 col-6 mb-3">' +
        '      <label class="form-label font-weight-bold">Amount</label>' +
        '      <input type="text" name="amount[]" class="form-control design-amount amount_1" readonly>' +
        '    </div>' +
        '  </div>' +
        '  <div class="text-end">' +
        '    <button type="button" class="btn btn-danger btn-sm remove-design-row">Remove</button>' +
        '  </div>' +
        '</div>'
    );
    $("#ChalanForm").append(newRow);
    updateChalanCardSelects();
});

// Remove design row
$(document).on("click", ".remove-design-row", function() {
    $(this).closest(".design-row").remove();
    calculateChalanTotalAmount();
    updateChalanCardSelects();
});

// Card select change
$(document).on("change", ".card-select", function() {
    var selectEl = $(this);
    var cardNo = selectEl.val();
    var row = selectEl.closest(".design-row");

    if (cardNo) {
        $.ajax({
            url: "data/get_order.php",
            type: "POST",
            data: { card_no: cardNo },
            dataType: "json",
            success: function(go) {
                if (go) {
                    row.find(".design-no-val").val(go.design_no || '');
                    row.find(".design-matching-val").val(go.matching_no || '');
                    
                    // Clear existing cuts
                    var cutsContainer = row.find(".cuts-container");
                    cutsContainer.empty();

                    // Parse cuts from order
                    if (go.cut) {
                        var cutsArray = go.cut.split(/,\s*/);
                        $.each(cutsArray, function(index, value) {
                            if (value.trim() !== '') {
                                var cutWrapper = $(
                                    '<div class="cut-input-wrapper d-flex align-items-center bg-light border rounded px-1" style="width: fit-content; margin-bottom: 2px;">' +
                                    '  <input type="number" step="any" class="cut-val-input form-control form-control-sm border-0 p-0 text-center" style="width: 50px; background: transparent; font-size: 12px; height: auto;">' +
                                    '  <button type="button" class="btn-close remove-cut-btn" style="font-size: 9px; padding: 2px; margin-left: 3px;" aria-label="Close"></button>' +
                                    '</div>'
                                );
                                cutWrapper.find('.cut-val-input').val(value.trim());
                                cutsContainer.append(cutWrapper);
                            }
                        });
                    }
                    
                    updateRowCalculations(row);
                } else {
                    row.find(".cuts-container").empty();
                    row.find(".design-no-val, .design-matching-val, .design-metre, .design-rate, .design-amount, .design-cut-hidden").val('');
                    calculateChalanTotalAmount();
                }
                updateChalanCardSelects();
            },
            error: function() {
                updateChalanCardSelects();
            }
        });
    } else {
        row.find(".cuts-container").empty();
        row.find(".design-no-val, .design-matching-val, .design-metre, .design-rate, .design-amount, .design-cut-hidden").val('');
        calculateChalanTotalAmount();
        updateChalanCardSelects();
    }
});

// Rate input change
$(document).on("input change", ".design-rate", function() {
    var row = $(this).closest(".design-row");
    updateRowCalculations(row);
});

// Add Cut click
$(document).on("click", ".add-cut-btn", function() {
    var row = $(this).closest(".design-row");
    var cutsContainer = row.find(".cuts-container");
    var cutWrapper = $(
        '<div class="cut-input-wrapper d-flex align-items-center bg-light border rounded px-1" style="width: fit-content; margin-bottom: 2px;">' +
        '  <input type="number" step="any" class="cut-val-input form-control form-control-sm border-0 p-0 text-center" style="width: 50px; background: transparent; font-size: 12px; height: auto;" value="0">' +
        '  <button type="button" class="btn-close remove-cut-btn" style="font-size: 9px; padding: 2px; margin-left: 3px;" aria-label="Close"></button>' +
        '</div>'
    );
    cutsContainer.append(cutWrapper);
    cutWrapper.find('.cut-val-input').select();
    updateRowCalculations(row);
});

// Cut input change
$(document).on("input change", ".cut-val-input", function() {
    var row = $(this).closest(".design-row");
    updateRowCalculations(row);
});

// Remove Cut click
$(document).on("click", ".remove-cut-btn", function() {
    var row = $(this).closest(".design-row");
    $(this).closest(".cut-input-wrapper").remove();
    updateRowCalculations(row);
});

function updateRowCalculations(row) {
    var totalMetre = 0;
    var cuts = [];
    row.find(".cut-val-input").each(function() {
        var val = parseFloat($(this).val()) || 0;
        cuts.push(val);
        totalMetre += val;
    });
    row.find(".design-metre").val(totalMetre.toFixed(2).replace(/\.00$/, ''));
    row.find(".design-cut-hidden").val(cuts.join(", "));

    var rate = parseFloat(row.find(".design-rate").val()) || 0;
    var amount = totalMetre * rate;
    row.find(".design-amount").val(amount.toFixed(2).replace(/\.00$/, ''));

    calculateChalanTotalAmount();
}

function calculateChalanTotalAmount() {
    var total = 0;
    $(".design-amount").each(function() {
        var val = parseFloat($(this).val()) || 0;
        total += val;
    });
    $("#total_amount").val(total.toFixed(2).replace(/\.00$/, ''));
}


// ==================== BILL / GST PAGE DYNAMIC LOGIC ====================
var cachedChalanOptions = '';

function loadBillChalanOptions(p_name, callback) {
    $.ajax({
        url: "data/get_party_chalans.php",
        type: "POST",
        data: { p_name: p_name },
        dataType: "json",
        success: function(data) {
            var optionsHtml = '<option value="">-- Select Chalan No --</option>';
            $.each(data, function(index, item) {
                optionsHtml += '<option value="' + item.chalan_no + '" data-amount="' + item.total_amount + '" data-design="' + (item.design_no || '') + '" data-metre="' + (item.total_metre || '') + '" data-rate="' + (item.rate || '') + '" data-amounts="' + (item.amount || '') + '">' + item.chalan_no + '</option>';
            });
            cachedChalanOptions = optionsHtml;
            if (callback) callback(optionsHtml);
        }
    });
}

// Party Name change on Bill/GST Page
$("#p_name").change(function () {
    if ($("#BillForm").length > 0) {
        var p_name = $(this).val();
        if (p_name) {
            loadBillChalanOptions(p_name, function(options) {
                $(".chalan-select").each(function() {
                    $(this).html(options);
                    var row = $(this).closest('.chalan-row');
                    row.find('.c_amount, .c_metre, .c_rate').val('');
                    row.find('.c_design').html('<option value="">-- Select Design --</option>');
                });
                calculateBillTotals();
                updateBillSelects();
            });
        }
    }
});

// Load initial options for Bill page (Edit Mode)
$(document).ready(function () {
    if ($("#BillForm").length > 0) {
        var initialParty = $("#p_name").val();
        if (initialParty) {
            // Fetch but preserve current selections on edit
            $.ajax({
                url: "data/get_party_chalans.php",
                type: "POST",
                data: { p_name: initialParty },
                dataType: "json",
                success: function(data) {
                    var optionsHtml = '<option value="">-- Select Chalan No --</option>';
                    $.each(data, function(index, item) {
                        optionsHtml += '<option value="' + item.chalan_no + '" data-amount="' + item.total_amount + '" data-design="' + (item.design_no || '') + '" data-metre="' + (item.total_metre || '') + '" data-rate="' + (item.rate || '') + '" data-amounts="' + (item.amount || '') + '">' + item.chalan_no + '</option>';
                    });
                    cachedChalanOptions = optionsHtml;
                    
                    // Attach data-attributes to pre-existing option tags on edit page
                    $(".chalan-select").each(function() {
                        var selectEl = $(this);
                        selectEl.find("option").each(function() {
                            var optionVal = $(this).val();
                            var matchedItem = data.find(function(i) { return i.chalan_no == optionVal; });
                            if (matchedItem) {
                                $(this).attr("data-amount", matchedItem.total_amount);
                                $(this).attr("data-design", matchedItem.design_no);
                                $(this).attr("data-metre", matchedItem.total_metre);
                                $(this).attr("data-rate", matchedItem.rate);
                                $(this).attr("data-amounts", matchedItem.amount);
                            }
                        });
                    });
                    calculateBillTotals();
                    updateBillSelects();
                }
            });
        }
    }
});

// Chalan select change
$(document).on("change", ".chalan-select", function() {
    var selectEl = $(this);
    var selectedOption = selectEl.find("option:selected");
    
    var designStr = selectedOption.attr("data-design") || '';
    var metreStr = selectedOption.attr("data-metre") || '';
    var rateStr = selectedOption.attr("data-rate") || '';
    var amountStr = selectedOption.attr("data-amounts") || '';
    
    var designs = designStr ? designStr.split(/\s*\/\s*/) : [];
    var metres = metreStr ? metreStr.split(/\s*\/\s*/) : [];
    var rates = rateStr ? rateStr.split(/\s*\/\s*/) : [];
    var amounts = amountStr ? amountStr.split(/\s*\/\s*/) : [];
    
    var row = selectEl.closest(".chalan-row");
    var designSelect = row.find(".c_design");
    
    // Clear and populate Design select
    designSelect.html('<option value="">-- Select Design --</option>');
    $.each(designs, function(index, designNo) {
        if (designNo) {
            var metreVal = metres[index] || '';
            var rateVal = rates[index] || '';
            var amountVal = amounts[index] || '';
            designSelect.append('<option value="' + designNo + '" data-metre="' + metreVal + '" data-rate="' + rateVal + '" data-amount="' + amountVal + '">' + designNo + '</option>');
        }
    });
    
    // Clear other fields until a design is selected
    row.find(".c_metre").val('');
    row.find(".c_rate").val('');
    row.find(".c_amount").val('');
    calculateBillTotals();
    updateBillSelects();
    
    // Auto-select first design if there's only one
    if (designs.length === 1 && designs[0]) {
        designSelect.val(designs[0]).trigger('change');
    }
});

// Design select change
$(document).on("change", ".c_design", function() {
    var selectEl = $(this);
    var selectedOption = selectEl.find("option:selected");
    var metre = selectedOption.attr("data-metre") || '';
    var rate = selectedOption.attr("data-rate") || '';
    var amount = selectedOption.attr("data-amount") || '';
    
    var row = selectEl.closest(".chalan-row");
    row.find(".c_metre").val(metre);
    row.find(".c_rate").val(rate);
    row.find(".c_amount").val(amount);
    
    calculateBillTotals();
    updateBillSelects();
});

// Calculate amount when Metre or Rate is edited manually
$(document).on("input", ".c_metre, .c_rate", function() {
    var row = $(this).closest(".chalan-row");
    var metre = parseFloat(row.find(".c_metre").val()) || 0;
    var rate = parseFloat(row.find(".c_rate").val()) || 0;
    var amount = metre * rate;
    row.find(".c_amount").val(amount.toFixed(2));
    calculateBillTotals();
    updateBillSelects();
});

// Remove chalan row
$(document).on("click", ".c_removeBtn", function() {
    $(this).closest(".chalan-row").remove();
    calculateBillTotals();
    updateBillSelects();
});

function calculateBillTotals() {
    var total_c_amount = 0;
    $(".c_amount").each(function() {
        var val = parseFloat($(this).val()) || 0;
        total_c_amount += val;
    });
    $("#total_c_amount").val(total_c_amount);

    var dis_rate = parseFloat($("#dis_rate").val()) || 0;
    var discountAmount = (total_c_amount * dis_rate) / 100;
    var finalAmountBeforeGst = total_c_amount - discountAmount;

    var cgst_rate = parseFloat($("#cgst_rate").val()) || 2.50;
    var sgst_rate = parseFloat($("#sgst_rate").val()) || 2.50;

    var cgstAmount = (finalAmountBeforeGst * cgst_rate) / 100;
    var sgstAmount = (finalAmountBeforeGst * sgst_rate) / 100;
    var total_gst_Amount = cgstAmount + sgstAmount;
    var finalAmount = finalAmountBeforeGst + total_gst_Amount;

    $("#dis_amount").val(discountAmount.toFixed(2));
    $("#cgst").val(cgstAmount.toFixed(2));
    $("#sgst").val(sgstAmount.toFixed(2));
    $("#totalgst").val(total_gst_Amount.toFixed(2));
    $("#final_amount").val(Math.round(finalAmount));

    calculateBillPending();
}

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

$(document).on("change", "#dis_rate", function() {
    calculateBillTotals();
});

$(document).on("input change", "#cgst_rate, #sgst_rate", function() {
    calculateBillTotals();
});

$(document).on("input", "#paid_amount", function() {
    calculateBillPending();
});


// ==================== ORDER / INVOICE PAGE DYNAMIC LOGIC ====================
function updateCount() {
    let total = $(".col-remove").length;
    let totalRowEl = document.getElementById("totalRow");
    if (totalRowEl) {
        totalRowEl.value = total;
    }
}

$(document).on("click", "#addRow", function () {
    if ($("#BillForm").length > 0) {
        // Bill Page Row Addition
        var options = cachedChalanOptions || '<option value="">-- Select Chalan No --</option>';
        var newRow = $(
            '<div class="row chalan-row mb-3 align-items-end">' +
            '  <div class="col-md-3 col-6 col-remove">' +
            '    <label class="form-label">Chalan No.</label>' +
            '    <select name="chalan_no[]" class="form-select chalan-select" required>' +
            '      ' + options +
            '    </select>' +
            '  </div>' +
            '  <div class="col-md-2 col-6">' +
            '    <label class="form-label">Design No.</label>' +
            '    <select name="design_no[]" class="form-select c_design" required>' +
            '      <option value="">-- Select Design --</option>' +
            '    </select>' +
            '  </div>' +
            '  <div class="col-md-2 col-6">' +
            '    <label class="form-label">Total Metre</label>' +
            '    <input type="text" name="total_metre[]" class="form-control c_metre">' +
            '  </div>' +
            '  <div class="col-md-2 col-6">' +
            '    <label class="form-label">Rate</label>' +
            '    <input type="text" name="rate[]" class="form-control c_rate">' +
            '  </div>' +
            '  <div class="col-md-2 col-6">' +
            '    <label class="form-label">Chalan Amount</label>' +
            '    <input type="text" name="c_amount[]" class="form-control c_amount" readonly>' +
            '  </div>' +
            '  <div class="col-md-1 col-6">' +
            '    <button type="button" class="btn btn-danger btn-sm c_removeBtn">Remove</button>' +
            '  </div>' +
            '</div>'
        );
        $("#BillForm").append(newRow);
        updateBillSelects();
    } else if ($("#invoiceForm").length > 0) {
        // Invoice/Order Page Row Addition
        var newRow = $(
            '<div class="row">' +
            '  <div class="col-4 mb-3 col-remove">' +
            '    <label class="form-label">Maching No.</label>' +
            '    <input type="text" name="matching_no[]" class="form-control" placeholder="Maching no">' +
            '  </div>' +
            '  <div class="col-4 mb-3">' +
            '    <label class="form-label">Cut</label>' +
            '    <input type="text" name="cut[]" class="form-control cut" placeholder="Cut">' +
            '  </div>' +
            '  <div class="col-4 mb-3 align-self-center removeBtn">' +
            '    Remove' +
            '    <span class="nav-icon">' +
            '      <iconify-icon icon="mingcute:close-line"></iconify-icon>' +
            '    </span>' +
            '  </div>' +
            '</div>'
        );
        $("#invoiceForm").append(newRow);
        updateCount();
    }
});

$(document).on("click", ".removeBtn", function () {
    $(this).closest(".row").remove();
    updateCount();
});

$(document).on("keyup", ".cut", function () {
    calculateTotalMetre();
});

function calculateTotalMetre() {
    let total = 0;
    $(".cut").each(function () {
        let cut = parseFloat($(this).val()) || 0;
        total += cut;
    });
    let totalMetreEl = document.getElementById("total_metre");
    if (totalMetreEl) {
        totalMetreEl.value = total;
        calculateOrderAmount();
    }
}

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

let orderRateEl = document.getElementById("rate");
if (orderRateEl) {
    orderRateEl.addEventListener("input", calculateOrderAmount);
}

// ==================== UNIQUE SELECTION ENFORCEMENT ====================

function updateChalanCardSelects() {
    if ($("#ChalanForm").length === 0) return;
    
    var selectedCards = [];
    $(".card-select").each(function() {
        var val = $(this).val();
        if (val) {
            selectedCards.push(val);
        }
    });

    $(".card-select").each(function() {
        var currentSelect = $(this);
        var currentVal = currentSelect.val();
        
        currentSelect.find("option").each(function() {
            var optVal = $(this).val();
            if (!optVal) return;
            
            if (selectedCards.indexOf(optVal) !== -1 && optVal !== currentVal) {
                $(this).prop('disabled', true).hide();
            } else {
                $(this).prop('disabled', false).show();
            }
        });
    });
}

function getChalanDetails(chalanNo) {
    var details = { designs: [], metres: [], rates: [], amounts: [] };
    $(".chalan-select").first().find("option").each(function() {
        if ($(this).val() == chalanNo) {
            var designStr = $(this).attr("data-design") || "";
            var metreStr = $(this).attr("data-metre") || "";
            var rateStr = $(this).attr("data-rate") || "";
            var amountStr = $(this).attr("data-amounts") || "";
            
            details.designs = designStr ? designStr.split(/\s*\/\s*/) : [];
            details.metres = metreStr ? metreStr.split(/\s*\/\s*/) : [];
            details.rates = rateStr ? rateStr.split(/\s*\/\s*/) : [];
            details.amounts = amountStr ? amountStr.split(/\s*\/\s*/) : [];
            return false; // break
        }
    });
    return details;
}

function updateBillSelects() {
    if ($("#BillForm").length === 0) return;

    // 1. Gather all currently selected (Chalan, Design) pairs
    var selectedPairs = [];
    $(".chalan-row").each(function() {
        var chalan = $(this).find(".chalan-select").val();
        var design = $(this).find(".c_design").val();
        if (chalan && design) {
            selectedPairs.push({ chalan: chalan, design: design, element: this });
        }
    });

    // 2. Rebuild Design options for each row, filtering out duplicates
    $(".chalan-row").each(function() {
        var row = $(this);
        var chalanSelect = row.find(".chalan-select");
        var designSelect = row.find(".c_design");
        
        var currentChalan = chalanSelect.val();
        var currentDesign = designSelect.val();
        
        if (!currentChalan) {
            designSelect.html('<option value="">-- Select Design --</option>');
            return;
        }
        
        // Get all possible designs and metadata for this chalan
        var details = getChalanDetails(currentChalan);
        
        // Rebuild the design dropdown options
        var designOptionsHtml = '<option value="">-- Select Design --</option>';
        $.each(details.designs, function(index, dsn) {
            if (!dsn) return;
            
            // Check if this design is selected in ANOTHER row
            var isSelectedElsewhere = selectedPairs.some(function(pair) {
                return pair.chalan === currentChalan && pair.design === dsn && pair.element !== row[0];
            });
            
            // Only add the option if it is not selected elsewhere
            if (!isSelectedElsewhere) {
                var metreVal = details.metres[index] || '';
                var rateVal = details.rates[index] || '';
                var amountVal = details.amounts[index] || '';
                designOptionsHtml += '<option value="' + dsn + '" data-metre="' + metreVal + '" data-rate="' + rateVal + '" data-amount="' + amountVal + '">' + dsn + '</option>';
            }
        });
        
        // Update the select options and restore the selection
        designSelect.html(designOptionsHtml);
        if (currentDesign) {
            designSelect.val(currentDesign);
        }
    });

    // 3. Update Chalan dropdown options in all rows
    $(".chalan-row").each(function() {
        var row = $(this);
        var chalanSelect = row.find(".chalan-select");
        var currentChalanVal = chalanSelect.val();
        
        chalanSelect.find("option").each(function() {
            var chalanOptVal = $(this).val();
            if (!chalanOptVal) return;
            
            var details = getChalanDetails(chalanOptVal);
            if (details.designs.length === 0) return;
            
            var selectedDesignsInOtherRows = 0;
            $.each(details.designs, function(idx, dsn) {
                var isSelectedElsewhere = selectedPairs.some(function(pair) {
                    return pair.chalan === chalanOptVal && pair.design === dsn && pair.element !== row[0];
                });
                if (isSelectedElsewhere) {
                    selectedDesignsInOtherRows++;
                }
            });
            
            if (selectedDesignsInOtherRows >= details.designs.length) {
                $(this).prop('disabled', true).hide();
            } else {
                $(this).prop('disabled', false).show();
            }
        });
    });
}
